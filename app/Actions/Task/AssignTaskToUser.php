<?php

namespace App\Actions\Task;

use App\Events\Task\TaskAssigned;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\User;

class AssignTaskToUser {
    /**
     * Responsible for taking a task and assigning it to a user when possible
     *
     * @param Task $task The task to be assigned
     * @param User $user The user who will be assigned the task
     *
     * @return Task
     * @throws TaskAssignmentException
     */
    public function handle(Task $task, User $user): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->where('task_status_id', TaskStatus::PENDING)
            ->whereNull('user_id')
            ->update([
                'task_status_id' => TaskStatus::ASSIGNED,
                'user_id' => $user->id,
                'assigned_at' => now()
            ]);

        if (0 == $rowsUpdated) {
            throw TaskAssignmentException::taskCouldNotBeAssigned();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'user_id' => $user->id,
        ]);

        TaskAssigned::dispatch($taskEvent);

        $task->refresh();

        return $task;
    }
}
