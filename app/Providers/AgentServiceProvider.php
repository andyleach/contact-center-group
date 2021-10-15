<?php

namespace App\Providers;

use App\Actions\Agent\AgentDisabling\GraceFullyDisableAgent;
use App\Contracts\Agent\DisablesAgentContract;
use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
{
    /**
     * @var string[] $bindings
     */
    public $bindings = [
        DisablesAgentContract::class => GraceFullyDisableAgent::class
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
