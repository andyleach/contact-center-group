<?php

namespace Tests\Feature\Task;

use App\Actions\Task\AssignTaskToAgent;
use App\Contracts\Task\AssignsTaskToAgentContract;
use App\Events\Task\TaskAssigned;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Agent\Agent;
use App\Models\Task\Task;
use App\Models\Task\TaskEvent;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentTest extends TestCase {
    use RefreshDatabase;

    /**
     * @var AssignTaskToAgent $action
     */
    protected AssignTaskToAgent $action;


    public function setUp(): void {
        parent::setUp();

        $this->action = app(AssignsTaskToAgentContract::class);
    }

    /**
     *
     */
    public function test_a_task_can_be_assigned_to_a_user() {
        /** @var Agent $agent */
        $agent = Agent::factory()->create();

        // A task with a status of pending should update one row
        /** @var Task $task */
        $task = Task::factory()->create([
            'assigned_at' => now()->subSecond()
        ]);

        // The TaskAssigned event should be thrown
        $this->expectsEvents(TaskAssigned::class);
        // A user_id should be assigned to the task when assigned
        $task = $this->action->handle($task, $agent);

        $this->assertInstanceOf(Task::class, $task, 'A task was not returned');

        // The assignment date should be set
        $this->assertNotNull($task->assigned_at, 'Assigned at is null');

        // The status should be set to "Task Assigned"
        $this->assertTrue(TaskStatus::ASSIGNED == $task->task_status_id);

        // A task event should be created
        $this->assertDatabaseHas(TaskEvent::class, [
            'task_event_type_id' => TaskEventType::TASK_ASSIGNED,
            'agent_id'            => $agent->id,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'task_id' => $task->id
        ]);
    }

    /**
     *
     */
    public function test_that_a_task_not_in_pending_status_cannot_be_assigned() {
        /** @var Agent $agent */
        $agent = Agent::factory()->create();

        /**
         * Create a task with a status that is not pending
         * @var Task $task
         */
        $task = Task::factory()->create([
            'task_status_id' => TaskStatus::DRAFT
        ]);

        $oldTask = $task->toArray();

        // Ensure that an exception is thrown
        $this->expectException(TaskAssignmentException::class);
        $this->doesntExpectEvents(TaskAssigned::class);
        $currentTask = $this->action->handle($task, $agent);

        $this->assertEquals($oldTask, $currentTask->toArray());

        /// A task event should be created
        $this->assertDatabaseMissing(TaskEvent::class, [
            'task_event_type_id' => TaskEventType::TASK_ASSIGNED,
            'user_id'            => $agent->id,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'task_id' => $task->id
        ]);
    }
}
