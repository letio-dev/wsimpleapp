<?php

namespace App\Providers;

use App\Helpers\UUIDConverter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('uuid', function () {
            return new UUIDConverter();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'local') {
            // \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
