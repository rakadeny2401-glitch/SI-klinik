<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
        //
=======
        $middleware->append(\App\Http\Middleware\SetupLegacyEnvironment::class);
>>>>>>> ac8524e09c4b6d8e79d9dab77789553ccb3097ea
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
