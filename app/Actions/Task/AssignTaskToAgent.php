<?php

namespace App\Actions\Task;

use App\Contracts\Task\AssignsTaskToAgentContract;
use App\Events\Task\TaskAssigned;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Agent\Agent;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;

class AssignTaskToAgent implements AssignsTaskToAgentContract {
    /**
     * Responsible for taking a task and assigning it to an agent when possible
     *
     * @param Task $task The task to be assigned
     * @param Agent $agent The agent who will be assigned the task
     *
     * @return Task
     * @throws TaskAssignmentException
     */
    public function handle(Task $task, Agent $agent): Task {
        $rowsUpdated = Task::query()
            ->where('id', $task->id)
            ->assignable()
            ->update([
                'task_status_id' => TaskStatus::ASSIGNED,
                'agent_id' => $agent->id,
                'assigned_at' => now()
            ]);

        if (0 == $rowsUpdated) {
            throw TaskAssignmentException::taskCouldNotBeAssigned();
        }

        $taskEvent = $task->taskEvents()->create([
            'task_event_type_id' => TaskEventType::TASK_ASSIGNED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'agent_id' => $agent->id,
        ]);

        TaskAssigned::dispatch($taskEvent);

        $task->refresh();

        return $task;
    }
}
