<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\CheckSubscription;
use App\Http\Middleware\CheckUserActive;
use App\Http\Middleware\TenantMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        /**
         * 🔥 GLOBAL MIDDLEWARE (MOST IMPORTANT)
         * 👉 EVERY request এ run হবে
         */
        $middleware->append([
            TenantMiddleware::class, // 👈 MUST
        ]);

        /**
         * 🔥 ALIAS (route middleware)
         */
        $middleware->alias([
            'role'         => RoleMiddleware::class,
            'subscription' => CheckSubscription::class,
            'active'       => CheckUserActive::class,
            'tenant'       => TenantMiddleware::class,
            'feature'      => \App\Http\Middleware\CheckFeature::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();