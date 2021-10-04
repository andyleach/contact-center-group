<?php

namespace App\Providers;

use App\Events\Task\TaskAssigned;
use App\Events\Task\TaskAssignmentCancelled;
use App\Events\Task\TaskClosed;
use App\Events\Task\TaskCloseFailed;
use App\Events\Task\TaskClosePending;
use App\Events\Task\TaskCreated;
use App\Events\Task\TaskExpired;
use App\Events\Task\TaskInProcess;
use App\Events\Task\TaskRemoved;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
