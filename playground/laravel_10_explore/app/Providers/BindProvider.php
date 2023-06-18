<?php

namespace App\Providers;

use App\Services\BindService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

//    Registered in config/app.php
class BindProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BindService::class, function (Application $app) {
            return new BindService('from bind provider test');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
