<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Events\Task\TaskAssigned;
use App\Events\Task\TaskAssignmentCancelled;
use App\Events\Task\TaskExpired;
use App\Exceptions\Task\TaskAssignmentException;
use App\Exceptions\Task\TaskInProcessException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\User;

class TaskRepository implements TaskRepositoryInterface {
    /**
     * Responsible for taking a task and assigning it to a user when possible
     *
     * @param Task $task The task to be assigned
     * @param User $user The user who will be assigned the task
     *
     * @return Task
     * @throws TaskAssignmentException
     */
    public function assignTask(Task $task, User $user): Task {
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
            throw TaskAssignmentException::taskHasAlreadyBeenAssigned();
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

    /**
     * @param Task $task
     * @param int $task_event_reason_id
     * @return Task
     * @throws TaskAssignmentException
     */
    public function cancelTaskAssignment(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
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

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNMENT_CANCELLED,
            'task_event_reason_id' => $task_event_reason_id,
            'user_id' => $assignedUser->id,
        ]);

        TaskAssignmentCancelled::dispatch($taskEvent);

        return $task;
    }

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
    public function expire(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->whereHas('taskStatus', function($query) {
                $query->where('is_expirable', true);
            })
            ->where('expires_at', '<=', now())
            ->update([
                'task_status_id' => TaskStatus::EXPIRED,
            ]);

        if (0 === $rowsUpdated) {
            throw new TaskInProcessException();
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
