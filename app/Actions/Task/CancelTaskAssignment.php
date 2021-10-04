<?php

namespace App\Actions\Task;

use App\Events\Task\TaskAssignmentCancelled;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;

class CancelTaskAssignment {

    /**
     * @param Task $task
     * @param int|null $task_event_reason_id
     * @return Task
     * @throws TaskAssignmentException
     */
    public function cancel(Task $task, int $task_event_reason_id = null): Task {
        $assignedUser = $task->user;

        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->where('task_status_id', TaskStatus::ASSIGNED)
            ->update([
                'task_status_id' => TaskStatus::PENDING,
                'user_id' => null,
                'assigned_at' => null
            ]);

        if (0 == $rowsUpdated) {
            throw TaskAssignmentException::unableToCancelAssignment();
        }

        if (null === $task_event_reason_id) {
            $task_event_reason_id = TaskEventReason::NOT_APPLICABLE;
        }

        $taskEvent = $task->taskEvent()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNMENT_CANCELLED,
            'task_event_reason_id' => $task_event_reason_id,
            'user_id' => $assignedUser->id,
        ]);

        TaskAssignmentCancelled::dispatch($taskEvent);

        return $task;
    }
}
