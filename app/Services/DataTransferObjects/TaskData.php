<?php

namespace App\Services\DataTransferObjects;

use App\Models\Task\TaskStatus;
use Carbon\Carbon;
use App\Models\Lead\Lead;
use App\Models\Task\TaskType;
use App\Models\Sequence\SequenceAction;
use Database\Factories\Task\TaskDataFactory;

class TaskData extends AbstractDataTransferObject {
    /**
     * Ensures that you can use factories to create task data.
     *
     * @return TaskDataFactory
     */
    public static function newFactory(): TaskDataFactory {
        return new TaskDataFactory();
    }

    /**
     * @var int $task_type_id The type of task to be performed
     */
    public int $task_type_id;

    public int $task_status_id = TaskStatus::DRAFT;

    /**
     * @var int|null $lead_id The lead the task was for
     */
    public ?int $lead_id;

    /**
     * @var null|int $sequence_action_id The sequence action IF any that created the task
     */
    public ?int $sequence_action_id = null;

    /**
     * @var string $instructions Instructions on what the agent should accomplish
     */
    public string $instructions;

    /**
     * @var Carbon The time the task will become available for working
     */
    public Carbon $available_at;

    /**
     * @var Carbon $expires_at The time in which the task will leave the system
     */
    public Carbon $expires_at;

    public static function fromLeadForSequenceAction(Lead $lead, SequenceAction $action): self {
        $data = new self;
        $data->lead_id = $lead->id;
        $data->task_type_id = $action->task_type_id;
        $data->sequence_action_id = $action->id;
        // TODO: Define a timezone for the client record
        $data->available_at = self::getTimeAfterDelay($action->scheduled_start_time, $action->delay_in_seconds);
        $data->expires_at   = self::calculateTimeForTaskExpiration($action->taskType, $data->available_at);
        $data->instructions = $action->instructions;

        return $data;
    }

    /**
     * Calculates the expiration time as defined by the task type from the date that the task first becomes available
     *
     * @param TaskType $taskType
     * @param Carbon $available_at
     * @return Carbon
     */
    public static function calculateTimeForTaskExpiration(TaskType $taskType, Carbon $available_at): Carbon {
        return now()->addHours(12);
    }

    /**
     * @param string|null $time     Time of day required
     * @param string|null $delay    Minimum delay required
     * @param string      $timezone Timezone of interest
     *
     * @return Carbon
     */
    public static function getTimeAfterDelay(?string $time, ?string $delay, string $timezone = 'America/New_York'): Carbon {
        // TODO: Define a timezone column for the client record
        // The default $waitUntil will be NOW -- no wait
        $waitUntil = now($timezone);

        // If we have a $delay, add it to the $waitUntil
        if (!empty($delay)) {
            $waitUntil->addSeconds($delay);
        }

        // If we have a $time, move $waitUntil forward until it is reached
        if (!empty($time)) {
            $time = explode(':', $time);
            $waitUntil->setTime($time[0], $time[1] ?? 0, $time[2] ?? 0);
            // If the time already passed today, try tomorrow
            if ($waitUntil->timestamp < microtime(true)) {
                $waitUntil->addDay();
            }
        }

        return $waitUntil;
    }

    public static function fromInboundCallData(InboundCallData $data): TaskData {
        $data = new self;
        $data->lead_id = null;
        // Keep it as a draft so that we can do lead and customer matching before routing to an agent
        $data->task_status_id = TaskStatus::DRAFT;
        $data->task_type_id = TaskType::INBOUND_CALL;
        $data->sequence_action_id = null;
        // TODO: Define a timezone for the client record
        $data->available_at = now();
        $data->expires_at   = now()->addMinutes(10);
        $data->instructions = "Answer the call";

        return $data;
    }
}
