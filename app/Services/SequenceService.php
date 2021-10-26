<?php

namespace App\Services;

use App\Models\Lead\Lead;
use App\Models\Task\Task;
use Carbon\Carbon;

class SequenceService {
    public function createSequence() {}
    public function updateSequence() {}

    /**
     * Each sequence action should require a unique identifier that should be specific to the sequence action.
     * Each sequence task should be tagged with the unique sequence identifier that was responsible for creating it
     * Each sequence identifier should be completely unique in the sequence
     * A failure to create a sequence action should not result in the sequence attempting to move onto the next task the next time createNextTask() is run. Instead it should try to recreate the one it failed to create previously
     * If a previously created sequence task is still open, do not allow a new one to be created.
     */

    public function createNextTask(Lead $lead): Task {
        return new Task();
    }

    /**
     * Used for calculating a next task time based on the time of day and delay required
     *
     * @param string|null $time     Time of day required
     * @param string|null $delay    Minimum delay required
     * @param string      $timezone Timezone of interest
     *
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
