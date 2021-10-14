<?php

namespace App\Actions\Task;

use App\Actions\Task\DataTransferObjects\TaskData;
use App\Contracts\Task\CreatesTaskForQueueContract;
use App\Models\Task\Task;

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
