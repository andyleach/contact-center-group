<?php

namespace App\Actions\Task;

use App\Contracts\Task\RemovesTaskFromQueueContract;
use App\Events\Task\TaskRemoved;
use App\Exceptions\Task\TaskRemovalException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;

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
                'completed_at' => now()
            ]);

        if (0 == $rowsUpdated) {
            throw TaskRemovalException::default();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_REMOVED,
            'task_event_reason_id' => $task_event_reason_id,
            'agent_id' => null,
        ]);

        TaskRemoved::dispatch($taskEvent);

        return $task;
    }
}
