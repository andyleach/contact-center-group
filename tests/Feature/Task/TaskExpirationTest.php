<?php

namespace Tests\Feature\Task;

use App\Domain\Task\Actions\MarkTaskAsExpired;
use App\Domain\Task\Contracts\MarksTaskAsExpiredContract;
use App\Domain\Task\Events\TaskExpired;
use App\Domain\Task\Exceptions\TaskInProcessException;
use App\Models\Task\Task;
use App\Models\Task\TaskEvent;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskExpirationTest extends TestCase {
    use RefreshDatabase;

    /**
     * @var MarksTaskAsExpiredContract $action
     */
    protected MarksTaskAsExpiredContract $action;


    public function setUp(): void {
        parent::setUp();

        $this->action = app(MarksTaskAsExpiredContract::class);
    }

    /**
     *
     */
    public function test_that_a_task_that_has_passes_its_expiration_date_can_be_marked_as_expired() {
        /** @var Task $task */
        $task = Task::factory()->create([
            'task_status_id' => TaskStatus::PENDING,
            'expires_at' => now()->subSecond()
        ]);

        $this->expectsEvents(TaskExpired::class);
        $this->action->handle($task);

        $this->assertInstanceOf(Task::class, $task);

        $this->assertDatabaseHas(Task::class, [
            'task_status_id' => TaskStatus::EXPIRED,
            'agent_id' => null,
            'assigned_at' => null,
        ]);

        $this->assertDatabaseHas(TaskEvent::class, [
            'task_id' => $task->id,
            'task_event_type_id' => TaskEventType::TASK_EXPIRED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'agent_id' => null,
        ]);
    }

    /**
     *
     */
    public function test_that_a_assigned_task_cannot_be_expired() {
        /** @var Task $task */
        $task = Task::factory()->create([
            'task_status_id' => TaskStatus::ASSIGNED,
            'expires_at' => now()->subSecond()
        ]);

        $this->expectException(TaskInProcessException::class);
        $this->action->handle($task);
    }
}
