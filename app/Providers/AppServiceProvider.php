<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
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
        // Deteksi otomatis domain aktif (localhost / ngrok / production)
        $currentHost = request()->getSchemeAndHttpHost();
        URL::forceRootUrl($currentHost);

        // Biar asset (Vite) ikut domain sekarang
        Config::set('app.asset_url', $currentHost);
    }
}
