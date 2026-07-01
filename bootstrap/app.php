<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ── Sanctum: enable Bearer token auth for all API routes ────────────
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);

        // ── JSON responses for unauthenticated API requests ──────────────────
        $middleware->redirectGuestsTo(fn ($request) => $request->expectsJson()
            ? null
            : route('login')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
