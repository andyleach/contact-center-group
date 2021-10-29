<?php

namespace App\Providers;

use App\Contracts\TwilioServiceContract;
use App\Services\Integrations\TwilioService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[] $bindings
     */
    public $bindings = [
        TwilioServiceContract::class => TwilioService::class
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
