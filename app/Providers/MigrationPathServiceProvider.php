<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationPathServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom([
            database_path('migrations'),
            database_path('migrations/tables'),
            database_path('migrations/procedures'),
            database_path('migrations/functions'),
        ]);
    }
}
