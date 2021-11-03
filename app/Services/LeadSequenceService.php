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
use App\Services\DataTransferObjects\TaskData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeadSequenceService extends SequenceService {

    /**
     * @param Sequence $sequence
     * @param Lead $lead
     * @return Lead
     * @throws \Exception
     */
    public function assignSequence(Sequence $sequence, Lead $lead): Lead {
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
    public function endSequence(Model $lead): Lead {
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
        return $lead->sequences()->wherePivotNull('closed_at')->exists();
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
    public function hasSequenceBeenAssignedPreviously(Sequence $sequence, Model $lead): bool {
        return $lead->sequences()
            ->wherePivot('sequence_id', $sequence->id)
            ->exists();
    }

    /**
     * @param Lead $lead
     * @return Task
     * @throws \Throwable
     */
    public function createNextTask(Model $lead): Task {
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
