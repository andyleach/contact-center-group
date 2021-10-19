<?php

namespace App\Providers;

use App\Contracts\AgentServiceContract;
use App\Contracts\TaskQueueServiceContract;
use App\Http\Services\AgentService;
use App\Http\Services\TaskQueueService;
use Illuminate\Support\ServiceProvider;

class ContactCenterServiceProvider extends ServiceProvider
{
    public $bindings = [
        AgentServiceContract::class => AgentService::class,
        TaskQueueServiceContract::class => TaskQueueService::class,
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
