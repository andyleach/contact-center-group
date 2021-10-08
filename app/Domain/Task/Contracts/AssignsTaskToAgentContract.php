<?php

namespace App\Domain\Task\Contracts;

use App\Models\Agent\Agent;
use App\Models\Task\Task;

interface AssignsTaskToAgentContract {
    /**
     * @param Task $task
     * @param Agent $agent
     * @return Task
     */
    public function handle(Task $task, Agent $agent): Task;
}
