<?php

namespace App\Domain\Task\Contracts;

use App\Models\Task\Task;

interface MarksTaskAsExpiredContract {
    /**
     * @param Task $task
     * @return Task
     */
    public function handle(Task $task): Task;
}
