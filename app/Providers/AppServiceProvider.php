<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        \App\Infrastructure\Models\Customer::observe(\App\Infrastructure\Observers\CustomerObserver::class);
        \App\Infrastructure\Models\Order::observe(\App\Infrastructure\Observers\OrderObserver::class);
    }
}
