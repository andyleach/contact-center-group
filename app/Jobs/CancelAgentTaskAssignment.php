<?php

namespace App\Jobs;

use App\Models\Task\Task;
use App\Models\Task\TaskEventReason;
use App\Services\TaskQueueService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exceptions\Task\TaskAssignmentException;

/**
 * Responsible for taking a task already assigned to the agent, and cancelling that assignment.
 * This can be dispatched synchronously, or can be issued as a delayed job so that if an agent fails to accept the
 * task in time, it can be added back to the general pool of available tasks.
 */
class CancelAgentTaskAssignment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Task $task;

    /**
     * Creates a new instance of the agent task time out job
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job
     *
     * @param TaskQueueService $service
     */
    public function handle(TaskQueueService $service)
    {
        try {
            $service->cancelTaskAssignment($this->task, TaskEventReason::NOT_APPLICABLE);
        } catch (TaskAssignmentException $exception) {
            // We were unable to cancel the task assignment

        }
    }
}
