<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
   /*      using: function () {
            // Only load custom routes if you have them
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/custom_routes.php'));
        } */
    )
    
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

            // alias for route usage
    $middleware->alias([
        'token' => \App\Http\Middleware\EnsureTokenIsValid::class,
    ]);

      // optionally add to api group for all API routes
    $middleware->api(prepend: [
        \App\Http\Middleware\EnsureTokenIsValid::class,
    ]);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // in these we  can report  execeotion  using the  report methods

     
    })->create();
