<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\AuthRepositoryInterface::class,
            \App\Repositories\AuthRepositoryDatabase::class
        );
        $this->app->bind(
            \App\Repositories\ClienteRepositoryInterface::class,
            \App\Repositories\ClienteRepositoryDatabase::class
        );
        $this->app->bind(
            \App\Repositories\SaleRepositoryInterface::class,
            \App\Repositories\SaleRepositoryDatabase::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
