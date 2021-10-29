<?php

namespace App\Services\DataTransferObjects;

use App\Models\Sequence\SequenceAction;
use Carbon\Carbon;

class TaskData {
    /**
     * @var int $task_type_id The type of task to be performed
     */
    public int $task_type_id;

    /**
     * @var array $unstructured_data Data that needs to be stored with the task, but isn't consistently needed
     */
    public array $unstructured_data = [];

    /**
     * @var Carbon The time the task will become available for working
     */
    public Carbon $available_at;

    public static function fromSequenceAction(SequenceAction $action): self {

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
