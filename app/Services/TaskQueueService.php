<?php

namespace App\Services;

use App\Events\Task\TaskAssigned;
use App\Events\Task\TaskAssignmentCancelled;
use App\Events\Task\TaskExpired;
use App\Events\Task\TaskRemoved;
use App\Exceptions\Task\TaskAssignmentException;
use App\Exceptions\Task\TaskInProcessException;
use App\Exceptions\Task\TaskRemovalException;
use App\Models\Agent\Agent;
use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Services\DataTransferObjects\TaskData;

class TaskQueueService {
    /**
     * @var AgentService $agentService
     */
    protected AgentService $agentService;

    /**
     *
     */
    public function __construct() {
        $this->agentService = app(AgentService::class);
    }

    /**
     * @param TaskData $taskData
     * @return Task
     */
    public function createTask(TaskData $taskData): Task {
        $task = Task::create([
            'sequence_action_id' => $taskData->sequence_action_id,
            'lead_id'            => $taskData->lead_id,
            'task_type_id'       => $taskData->task_type_id,
            'available_at'       => $taskData->available_at,
            'expires_at'         => $taskData->expires_at,
        ]);

        return $task;
    }

    /**
     * @param Task $task
     * @param Agent $agent
     * @return Task
     * @throws TaskAssignmentException
     */
    public function assignTaskToAgent(Task $task, Agent $agent): Task {
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

    public function cancelTaskAssignment(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
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

    public function expire(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
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
            'agent_id' => null,
        ]);

        TaskExpired::dispatch($taskEvent);

        return $task;
    }

    public function remove(Task $task, int $task_event_reason_id = TaskEventReason::NOT_APPLICABLE): Task {
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
