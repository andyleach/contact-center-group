<?php

namespace App\Providers;

use App\Actions\Lead\CreateNewLead;
use App\Contracts\Lead\CreatesNewLeadContract;
use Illuminate\Support\ServiceProvider;

class LeadServiceProvider extends ServiceProvider
{
    public $bindings = [
        CreatesNewLeadContract::class => CreateNewLead::class
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
