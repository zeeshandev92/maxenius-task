<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RemoveXFrameOptions;
use App\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->use([
            \Illuminate\Session\Middleware\StartSession::class,
            VerifyCsrfToken::class,
            HandleInertiaRequests::class,
            RemoveXFrameOptions::class,
        ]);

        // $middleware->web(append: [
        //     VerifyCsrfToken::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
