<?php

namespace App\Providers;

use App\Actions\Agent\AgentDisabling\GracefullyDisableAgent;
use App\Actions\Roster\ManuallyAssignAgentHoursOnRoster;
use App\Actions\Roster\RemoveAllHoursFromAgentOnRoster;
use App\Contracts\Agent\DisablesAgentContract;
use App\Contracts\Roster\AssignsAgentHoursOnRosterContract;
use App\Contracts\Roster\RemovesHoursFromAgentOnRosterContract;
use Illuminate\Support\ServiceProvider;

class RosterServiceProvider extends ServiceProvider
{
    /**
     * @var string[] $bindings
     */
    public $bindings = [
        AssignsAgentHoursOnRosterContract::class => ManuallyAssignAgentHoursOnRoster::class,
        RemovesHoursFromAgentOnRosterContract::class => RemoveAllHoursFromAgentOnRoster::class
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
