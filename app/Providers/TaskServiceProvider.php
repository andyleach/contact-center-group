<?php

namespace App\Providers;

use App\Actions\Task\AssignTaskToAgent;
use App\Actions\Task\CancelTaskAssignment;
use App\Actions\Task\CreateTaskForQueue;
use App\Actions\Task\MarkTaskAsExpired;
use App\Actions\Task\RemoveTaskFromQueue;
use App\Contracts\Task\AssignsTaskToAgentContract;
use App\Contracts\Task\CancelsTaskAssignmentContract;
use App\Contracts\Task\CreatesTaskForQueueContract;
use App\Contracts\Task\MarksTaskAsExpiredContract;
use App\Contracts\Task\RemovesTaskFromQueueContract;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public $bindings = [
        AssignsTaskToAgentContract::class => AssignTaskToAgent::class,
        CancelsTaskAssignmentContract::class => CancelTaskAssignment::class,
        MarksTaskAsExpiredContract::class => MarkTaskAsExpired::class,
        RemovesTaskFromQueueContract::class => RemoveTaskFromQueue::class,
        CreatesTaskForQueueContract::class => CreateTaskForQueue::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
