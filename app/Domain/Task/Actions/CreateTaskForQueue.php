<?php

namespace App\Domain\Task\Actions;

use App\Domain\Task\Contracts\CreatesTaskForQueueContract;
use App\Domain\Task\DataTransferObjects\TaskData;
use App\Domain\Task\Models\Task;

class CreateTaskForQueue implements CreatesTaskForQueueContract {

    /**
     * @param TaskData $taskData
     * @return Task
     */
    public function handle(TaskData $taskData): Task {
        $task = Task::factory()->create([
            'task_type_id' => $taskData->task_type_id,
            'unstructured_data' => $taskData->unstructured_data,
            'available_at' => $taskData->available_at
        ]);

        return $task;
    }
}
