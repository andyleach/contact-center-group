<?php

namespace App\Providers;

use App\Domain\Task\Actions\AssignTaskToUser;
use App\Domain\Task\Actions\CancelTaskAssignment;
use App\Domain\Task\Actions\CreateTaskForQueue;
use App\Domain\Task\Actions\MarkTaskAsExpired;
use App\Domain\Task\Actions\RemoveTaskFromQueue;
use App\Domain\Task\Contracts\AssignsTaskToUserContract;
use App\Domain\Task\Contracts\CancelsTaskAssignmentContract;
use App\Domain\Task\Contracts\CreatesTaskForQueueContract;
use App\Domain\Task\Contracts\MarksTaskAsExpiredContract;
use App\Domain\Task\Contracts\RemovesTaskFromQueueContract;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public $bindings = [
        AssignsTaskToUserContract::class => AssignTaskToUser::class,
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
