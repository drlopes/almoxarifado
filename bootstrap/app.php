<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\ResponseCache\Middlewares\CacheResponse;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Fix for "Route [login] not defined" exception when using JeffGreco13\FilamentBreezy plugin
        // according to fix provided in https://github.com/filamentphp/filament/discussions/5226
        $middleware->redirectGuestsTo('login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
