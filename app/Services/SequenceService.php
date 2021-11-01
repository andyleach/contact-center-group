<?php

namespace App\Services;

use App\Events\Lead\LeadAssignedSequence;
use App\Events\Lead\LeadClosedSequence;
use App\Exceptions\Sequence\MissingAssignedSequenceException;
use App\Exceptions\Sequence\MissingNextSequenceActionException;
use App\Models\Lead\Lead;
use App\Models\Pivot\LeadSequence;
use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use App\Models\Task\Task;
use App\Services\DataTransferObjects\SequenceActionData;
use App\Services\DataTransferObjects\SequenceData;
use App\Services\DataTransferObjects\TaskData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SequenceService {
    /**
     * @param SequenceData $data
     * @return Sequence
     * @throws \Throwable
     */
    public function createSequence(SequenceData $data): Sequence {
        return DB::transaction(function() use($data) {
            $sequence = Sequence::create([
                'label' => $data->label,
                'description' => $data->description,
                'cost_per_lead_in_usd' => $data->cost_per_lead_in_usd,
                'client_id' => $data->client_id,
            ]);

            foreach ($data->sequence_actions as $action) {
                $action->sequence_id = $sequence->id;
                $this->updateOrCreateSequenceAction($action);
            }

            return $sequence;
        });
    }

    /**
     * @param Sequence $sequence
     * @param SequenceData $data
     * @return mixed
     * @throws \Throwable
     */
    public function updateSequence(Sequence $sequence, SequenceData $data) {
        // Execute this in a transaction so as to prevent dirty reads from the DB for sequence actions
        return $sequence = DB::transaction(function() use ($sequence, $data) {
            $sequence->label = $data->label;
            $sequence->description = $data->description;
            $sequence->save();

            /** Loop through all the new sequence actions $action that have been sent, and verify */
            foreach ($data->sequence_actions as $action) {
                $action->sequence_id = $sequence->id;
                $this->updateOrCreateSequenceAction($action);
            }

            return $sequence;
        });
    }

    /**
     * Receives a sequence action data transfer object, and then determines whether or not to update it or create
     * a new sequence action.
     *
     * @param SequenceActionData $data
     * @return SequenceAction
     */
    public function updateOrCreateSequenceAction(SequenceActionData $data): SequenceAction {
        /** @var SequenceAction $sequenceAction */
        return $sequenceAction = SequenceAction::updateOrCreate([
            'id' => $data->sequence_action_id
        ], [
            'sequence_id' => $data->sequence_id,
            'task_type_id' => $data->task_type_id,
            'scheduled_start_time' => $data->scheduled_start_time,
            'delay_in_seconds' => $data->delay_in_seconds,
            'instructions' => $data->instructions,
            'ordinal_position' => $data->ordinal_position,
        ]);

        // At a future date, we will tie in the creation of task restrictions to this method as well
    }

    /**
     * Each sequence action should require a unique identifier that should be specific to the sequence action.
     * Each sequence task should be tagged with the unique sequence identifier that was responsible for creating it
     * Each sequence identifier should be completely unique in the sequence
     * A failure to create a sequence action should not result in the sequence attempting to move onto the next task the next time createNextTask() is run. Instead it should try to recreate the one it failed to create previously
     * If a previously created sequence task is still open, do not allow a new one to be created.
     */

    /**
     * @param Lead $lead
     * @param Sequence $sequence
     * @return Lead
     * @throws \Throwable
     */
    public function assignSequenceAndCreateTask(Lead $lead, Sequence $sequence): Lead {
        $sequenceService = $this;

        return DB::transaction(function() use ($sequenceService, $lead, $sequence) {
            $sequenceService->assignSequence($sequence, $lead);

            return $sequenceService->createNextTask($lead);
        });
    }

    /**
     * @param Sequence $sequence
     * @param Lead $lead
     * @return Model
     * @throws \Exception
     */
    public function assignSequence(Sequence $sequence, Lead $lead): Model {
        $hasOpenSequence = $this->hasOpenSequence($lead);
        if (true == $hasOpenSequence) {
            throw new \Exception('An open sequence already exists for the lead '. $lead->id);
        }

        $hasSequenceBeenPreviouslyAssigned = $this->hasSequenceBeenAssignedPreviously($sequence, $lead);
        if (true == $hasSequenceBeenPreviouslyAssigned) {
            throw new \Exception('The sequence ' . $sequence->label
                .' has previously been assigned to lead #'. $lead->id
            );
        }

        // Ensure that the sequence to be assigned hasn't been assigned previously
        $sequence->leads()->save($lead, [
            'assigned_at' => now()
        ]);

        LeadAssignedSequence::dispatch($lead);

        return $lead;
    }

    /**
     * Ends a sequence being performed against
     *
     * @param Lead $lead
     * @return Lead
     */
    public function endSequence(Lead $lead): Lead {
        // Update the pivot to ensure that the sequence has been closed
        $lead->sequences()->updateExistingPivot($lead->id, [
            'closed_at' => now()
        ]);

        LeadClosedSequence::dispatch($lead);

        return new Lead();
    }

    /**
     * Is there an existing open sequence on the lead
     * @param Lead $lead
     * @return bool
     */
    public function hasOpenSequence(Lead $lead): bool {
        // Ensure that there isn't an open sequence
        return $lead->openSequence()->exists();
    }

    /**
     * A query to determine if a sequence has been previously assigned to a lead.
     *
     * This is a mechanism to prevent a sequence from accidentally being assigned twice.
     *
     * @param Sequence $sequence
     * @param Lead $lead
     * @return bool
     */
    public function hasSequenceBeenAssignedPreviously(Sequence $sequence, Lead $lead): bool {
        return $lead->sequences()
            ->wherePivot('sequence_id', $sequence->id)
            ->exists();
    }

    /**
     * @param Lead $lead
     * @return Task
     * @throws \Throwable
     */
    public function createNextTask(Lead $lead): Task {
        return DB::transaction(function() use ($lead) {
            // Look for an open sequence that belongs to the lead
            $leadSequence = LeadSequence::query()
                ->where('lead_id', $lead->id)
                ->isClosed()
                // Locks the row to prevent updating https://laravel.com/docs/5.6/queries#pessimistic-locking
                ->sharedLock()
                ->first();

            // We found no sequence for the lead that was opened
            if (null == $leadSequence) {
                throw MissingAssignedSequenceException::create($lead);
            }

            // Find the next sequence action for the sequence
            $upcomingSequenceAction = SequenceAction::query()
                ->afterSequencePosition($leadSequence->sequence_id, $leadSequence->sequenceAction->ordinal_position)
                ->orderBy('ordinal_position', 'asc')
                // Locks the row to prevent updating https://laravel.com/docs/5.6/queries#pessimistic-locking
                ->sharedLock()
                ->first();

            // We found no next sequence action
            if (null == $upcomingSequenceAction) {
                throw MissingNextSequenceActionException::create($leadSequence);
            }

            // Build the task data from the sequence action
            $taskData = TaskData::fromLeadForSequenceAction($lead, $upcomingSequenceAction);

            // Create the task from the task data generated from the sequence action
            $task = app(TaskQueueService::class)->createTask($taskData);

            // Update the last sequence action created
            $leadSequence->sequence_action_id = $task->sequence_action_id;
            $leadSequence->save();

            return $task;
        });
    }
}
