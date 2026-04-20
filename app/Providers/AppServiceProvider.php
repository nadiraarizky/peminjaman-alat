<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon; // Tambahkan import ini

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
        // Mengatur bahasa Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');
        
        // Mengatur timezone ke Jakarta agar perhitungan jam akurat
        date_default_timezone_set('Asia/Jakarta');
    }
}