<?php

namespace App\Contracts\Task;

use App\Models\Task\Task;

interface CancelsTaskAssignmentContract {
    /**
     * @param Task $task
     * @return Task
     */
    public function handle(Task $task): Task;
}
