<?php

namespace Tests\Feature\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Domain\Task\Actions\MarkTaskAsExpired;
use App\Domain\Task\Events\TaskExpired;
use App\Domain\Task\Exceptions\TaskInProcessException;
use App\Domain\Task\Models\Task;
use App\Domain\Task\Models\TaskEvent;
use App\Domain\Task\Models\TaskEventReason;
use App\Domain\Task\Models\TaskEventType;
use App\Domain\Task\Models\TaskStatus;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskExpirationTest extends TestCase {
    use RefreshDatabase;

    /**
     * @var MarkTaskAsExpired $action
     */
    protected MarkTaskAsExpired $action;


    public function setUp(): void {
        parent::setUp();

        $this->action = app(MarkTaskAsExpired::class);
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
            'user_id' => null,
            'assigned_at' => null,
        ]);

        $this->assertDatabaseHas(TaskEvent::class, [
            'task_id' => $task->id,
            'task_event_type_id' => TaskEventType::TASK_EXPIRED,
            'task_event_reason_id' => TaskEventReason::NOT_APPLICABLE,
            'user_id' => null,
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
