<?php

namespace Tests\Feature\Task;

use App\Domain\Task\Actions\CancelTaskAssignment;
use App\Domain\Task\Events\TaskAssignmentCancelled;
use App\Domain\Task\Exceptions\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEvent;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelTaskAssignmentTest extends TestCase {
    use RefreshDatabase;

    /**
     * @var CancelTaskAssignment $action
     */
    protected CancelTaskAssignment $action;


    public function setUp(): void {
        parent::setUp();

        $this->action = app(CancelTaskAssignment::class);
    }

    /**
     *
     */
    public function test_that_a_task_assignment_can_be_cancelled() {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Task $task */
        $task = Task::factory()->create([
            'task_status_id' => TaskStatus::ASSIGNED,
            'user_id' => $user->id,
            'assigned_at' => now()
        ]);

        $this->expectsEvents(TaskAssignmentCancelled::class);
        $task = $this->action->handle($task);
        $this->assertInstanceOf(Task::class, $task);

        $this->assertDatabaseHas(Task::class, [
            'task_status_id' => TaskStatus::PENDING,
            'user_id' => null,
            'assigned_at' => null,
        ]);

        $this->assertDatabaseHas(TaskEvent::class, [
            'task_id' => $task->id,
            'task_event_type_id' => TaskEventType::TASK_ASSIGNMENT_CANCELLED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'user_id' => $user->id,
        ]);
    }

    /**
     *
     */
    public function test_that_a_failure_to_cancel_task_assignment_throws_exception() {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Task $task */
        $task = Task::factory()->create([
            'task_status_id' => TaskStatus::PENDING,
            'user_id' => null,
            'assigned_at' => null
        ]);

        $this->expectException(TaskAssignmentException::class);
        $this->action->handle($task);
    }
}
