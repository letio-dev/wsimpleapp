<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthCheck;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan semua route untuk aplikasi ini.
     *
     * @return void
     */
    public function boot()
    {
        Route::aliasMiddleware('auth.app', AuthCheck::class);

        // Daftarkan route middleware (optional)
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Bisa juga buat custom group atau route tertentu
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Daftarkan binding atau lainnya jika diperlukan
     *
     * @return void
     */
    public function register()
    {
        // Kamu bisa mengonfigurasi lebih lanjut jika perlu
    }
}
