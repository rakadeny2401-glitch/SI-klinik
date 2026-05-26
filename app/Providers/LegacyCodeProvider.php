<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LegacyCodeProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register legacy database connection
        $this->app->singleton('legacy.db', function () {
            $servername = env('DB_HOST', 'localhost');
            $username = env('DB_USERNAME', 'root');
            $password = env('DB_PASSWORD', '123');
            $dbname = env('DB_DATABASE', 'puskesmas');

            $koneksi = new \mysqli($servername, $username, $password, $dbname);

            if ($koneksi->connect_error) {
                die("Koneksi gagal: " . $koneksi->connect_error);
            }

            $koneksi->set_charset("utf8");
            return $koneksi;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Setup global koneksi variable for legacy code
        global $koneksi;
        $koneksi = app('legacy.db');
    }
}
