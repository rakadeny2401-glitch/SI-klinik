<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetupLegacyEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Laravel handles sessions automatically, don't start another session
        // Legacy PHP code can access session via Laravel's Session facade or $_SESSION
        
        // Make database connection available globally
        global $koneksi;
        $koneksi = app('legacy.db');

        // Setup base path for legacy code
        define('BASE_PATH', base_path() . '/', false);
        define('PUBLIC_PATH', public_path() . '/', false);

        return $next($request);
    }
}
