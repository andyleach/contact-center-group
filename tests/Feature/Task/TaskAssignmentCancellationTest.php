<?php

namespace Tests\Feature\Task;

use App\Contracts\TaskRepositoryInterface;
use App\Events\Task\TaskAssignmentCancelled;
use App\Exceptions\Task\TaskAssignmentException;
use App\Models\Task\Task;
use App\Models\Task\TaskEvent;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentCancellationTest extends TestCase {
    use RefreshDatabase;

    /**
     * @var TaskRepositoryInterface $taskRepository
     */
    protected TaskRepositoryInterface $taskRepository;


    public function setUp(): void {
        parent::setUp();

        $this->taskRepository = app(TaskRepositoryInterface::class);
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
        $task = $this->taskRepository->cancelTaskAssignment($task);
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
        $this->taskRepository->cancelTaskAssignment($task);
    }
}
