<?php

namespace App\Actions\Task;

use App\Events\Task\TaskAssigned;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignTaskToUser {
    /**
     * @param Task $task
     * @param User $user
     * @return Task
     * @throws TaskAssignmentException
     */
    public function assign(Task $task, User $user): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->where('task_status_id', TaskStatus::PENDING)
            ->whereNull('user_id', $user->id)
            ->update([
                'user_id' => $user->id,
                'assigned_at' => now()
            ]);

        if (0 == $rowsUpdated) {
            throw TaskAssignmentException::taskHasAlreadyBeenAssigned();
        }

        $taskEvent = $task->taskEvent()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'user_id' => $user->id,
        ]);

        TaskAssigned::dispatch($taskEvent);

        return $task;
    }
}
