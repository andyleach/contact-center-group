<?php

namespace App\Domain\Task\Actions;

use App\Domain\Task\Contracts\RemovesTaskFromQueueContract;
use App\Domain\Task\Events\TaskRemoved;
use App\Domain\Task\Exceptions\TaskRemovalException;
use App\Domain\Task\Models\Task;
use App\Domain\Task\Models\TaskEventReason;
use App\Domain\Task\Models\TaskEventType;
use App\Domain\Task\Models\TaskStatus;

class RemoveTaskFromQueue implements RemovesTaskFromQueueContract {

    /**
     * @param Task $task
     * @param int $task_event_reason_id
     * @return Task
     * @throws TaskRemovalException
     */
    public function handle(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->where('task_status_id', TaskStatus::PENDING)
            ->update([
                'task_status_id' => TaskStatus::REMOVED,
                'closed_at' => now()
            ]);

        if (0 == $rowsUpdated) {
            throw TaskRemovalException::default();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_REMOVED,
            'task_event_reason_id' => $task_event_reason_id,
            'user_id' => null,
        ]);

        TaskRemoved::dispatch($taskEvent);

        return $task;
    }
}
