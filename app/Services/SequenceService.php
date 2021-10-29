<?php

namespace App\Services;

use App\Events\Lead\LeadAssignedSequence;
use App\Events\Lead\LeadClosedSequence;
use App\Models\Lead\Lead;
use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use App\Models\Task\Task;
use App\Services\DataTransferObjects\SequenceData;
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
                'sequence_type_id' => $data->sequence_type_id
            ]);

            foreach ($data->sequence_actions as $action) {
                SequenceAction::create([
                    'sequence_id' => $sequence->id,
                    'task_type_id' => $action->task_type_id,
                    'scheduled_start_time' => $action->scheduled_start_time,
                    'delay_in_seconds' => $action->delay_in_seconds,
                    'instructions' => $action->instructions
                ]);
            }

            return $sequence;
        });
    }
    public function updateSequence(Sequence $sequence, SequenceData $data) {}

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
        $sequenceService = $this;

        return DB::transaction(function() use ($sequenceService, $lead) {
            $sequence = $lead->openSequence()->first();
            if (null == $sequence) {
                throw new \Exception('There is no open sequence for the lead #'. $lead->id);
            }

            $lead->sequence->pivot->
            return new Task();
        });
    }

    /**
     * @param string|null $time     Time of day required
     * @param string|null $delay    Minimum delay required
     * @param string      $timezone Timezone of interest
     * @return Carbon
     */
    public function getTimeAfterDelay(?string $time, ?string $delay, string $timezone): Carbon {
        // The default $waitUntil will be NOW -- no wait
        $waitUntil = now($timezone);

        // If we have a $delay, add it to the $waitUntil
        if (!empty($delay)) {
            $delay = explode(':', $delay);
            $delay = (3600 * $delay[0] ?? 0) + (60 * $delay[1] ?? 0) + ($delay[2] ?? 0);
            $waitUntil->addSeconds($delay);
        }


        // If we have a $time, move $waitUntil forward until it is reached
        if (!empty($time)) {
            $time = explode(':', $time);
            $waitUntil->setTime($time[0], $time[1] ?? 0, $time[2] ?? 0);
            // If the time already passed today, try tomorrow
            if ($waitUntil->timestamp < microtime(true)) {
                $waitUntil->addDay(1);
            }
        }

        return $waitUntil;
    }
}
