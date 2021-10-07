<?php

namespace App\Domain\Task\Actions;

use App\Domain\Task\Contracts\AssignsTaskToUserContract;
use App\Domain\Task\Events\TaskAssigned;
use App\Domain\Task\Exceptions\TaskAssignmentException;
use App\Domain\Task\Models\Task;
use App\Domain\Task\Models\TaskEventReason;
use App\Domain\Task\Models\TaskEventType;
use App\Domain\Task\Models\TaskStatus;
use App\Models\User;

class AssignTaskToUser implements AssignsTaskToUserContract {
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
            ->where
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
