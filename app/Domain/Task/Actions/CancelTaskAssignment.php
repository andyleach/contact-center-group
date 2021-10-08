<?php

namespace App\Domain\Task\Actions;

use App\Domain\Task\Contracts\CancelsTaskAssignmentContract;
use App\Domain\Task\Events\TaskAssignmentCancelled;
use App\Domain\Task\Exceptions\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;

class CancelTaskAssignment implements CancelsTaskAssignmentContract {
    /**
     * @param Task $task
     * @param int $task_event_reason_id
     * @return Task
     * @throws TaskAssignmentException
     */
    public function handle(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
        $assignedUser = $task->agent;

        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->where('task_status_id', TaskStatus::ASSIGNED)
            ->update([
                'task_status_id' => TaskStatus::PENDING,
                'agent_id' => null,
                'assigned_at' => null
            ]);

        if (0 == $rowsUpdated) {
            throw TaskAssignmentException::unableToCancelAssignment();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNMENT_CANCELLED,
            'task_event_reason_id' => $task_event_reason_id,
            'agent_id' => $assignedUser->id,
        ]);

        TaskAssignmentCancelled::dispatch($taskEvent);

        return $task;
    }
}
