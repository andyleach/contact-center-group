<?php

namespace App\Providers;

use App\Contracts\AgentServiceContract;
use App\Contracts\TaskQueueServiceContract;
use App\Http\Services\AgentService;
use App\Http\Services\TaskQueueService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        AgentServiceContract::class => AgentService::class,
        TaskQueueServiceContract::class => TaskQueueService::class,
    ];
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
