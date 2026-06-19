<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class LegacyCodeProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('legacy.db', function () {
            return DB::connection()->getPdo();
        });
    }

    public function boot(): void
    {
        global $koneksi;
        $koneksi = app('legacy.db');
    }
}
