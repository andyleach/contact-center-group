<?php

namespace App\Domain\Task\DataTransferObjects;

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
}
