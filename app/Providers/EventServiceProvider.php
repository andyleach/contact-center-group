<?php

namespace App\Providers;

use App\Domain\Task\Events\TaskAssigned;
use App\Domain\Task\Events\TaskAssignmentCancelled;
use App\Domain\Task\Events\TaskClosed;
use App\Domain\Task\Events\TaskCloseFailed;
use App\Domain\Task\Events\TaskClosePending;
use App\Domain\Task\Events\TaskCreated;
use App\Domain\Task\Events\TaskExpired;
use App\Domain\Task\Events\TaskInProcess;
use App\Domain\Task\Events\TaskRemoved;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        /*********************************************************
         * Task Events
         ********************************************************/
        TaskAssigned::class => [],
        TaskAssignmentCancelled::class => [],
        TaskClosed::class => [],
        TaskCloseFailed::class => [],
        TaskClosePending::class => [],
        TaskCreated::class => [],
        TaskExpired::class => [],
        TaskInProcess::class => [],
        TaskRemoved::class => [],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
