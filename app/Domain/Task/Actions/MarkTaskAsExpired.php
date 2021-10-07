<?php

namespace App\Domain\Task\Actions;

use App\Domain\Task\Contracts\MarksTaskAsExpiredContract;
use App\Domain\Task\Events\TaskExpired;
use App\Domain\Task\Exceptions\TaskInProcessException;
use App\Domain\Task\Models\Task;
use App\Domain\Task\Models\TaskEventReason;
use App\Domain\Task\Models\TaskEventType;
use App\Domain\Task\Models\TaskStatus;

class MarkTaskAsExpired implements MarksTaskAsExpiredContract {
    /**
     * Marks a task as having expired and notifies the rest of the system
     *
     * @param Task $task                 The task we are marking as having expired
     * @param int  $task_event_reason_id The reason we have marked it as having expired
     *
     * @return Task
     *
     * @throws TaskInProcessException
     */
    public function handle(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->expirable()
            ->update([
                'task_status_id' => TaskStatus::EXPIRED,
            ]);

        if (0 === $rowsUpdated) {
            throw TaskInProcessException::default();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_EXPIRED,
            'task_event_reason_id' => $task_event_reason_id,
            'user_id' => null,
        ]);

        TaskExpired::dispatch($taskEvent);

        return $task;
    }
}
