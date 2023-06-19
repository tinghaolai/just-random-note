<?php

namespace App\Providers;

use App\Interfaces\ContextualBindingInterface;
use App\Repositories\ContextualBindingRepositories;
use App\Services\ContextualBindingAService;
use App\Services\ContextualBindingBService;
use Illuminate\Support\ServiceProvider;

class ContextualBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->when(ContextualBindingAService::class)
          ->needs(ContextualBindingRepositories::class)
          ->give(function () {
              return new ContextualBindingRepositories('from provider');
          });

        $this->app->when(ContextualBindingBService::class)
            ->needs(ContextualBindingInterface::class)
            ->give(function () {
                return new ContextualBindingRepositories('from provider interface');
            });
    }
}
