<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Branch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Branch\Context::class, fn() => new \App\Branch\Context());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
