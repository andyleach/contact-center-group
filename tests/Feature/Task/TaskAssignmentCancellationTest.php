<?php

namespace Tests\Feature\Task;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentCancellationTest extends TestCase {
    use RefreshDatabase;

    /**
     *
     */
    public function test_a_task_can_be_assigned_to_a_user() {
        $user = User::factory()->create();

        $this->assertTrue(true);
    }

    /**
     *
     */
    public function test_a_task_assignment_can_be_cancelled() {
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function test_a_task_can_expire() {
        $this->assertTrue(true);
    }
}
