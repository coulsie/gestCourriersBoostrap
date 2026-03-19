<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Redirections automatiques
        $middleware->redirectTo(
            guests: '/login',
            users: '/home'
        );

        // 2. Exceptions CSRF
        $middleware->validateCsrfTokens(except: [
            'login',
            'logout'
        ]);

        // 3. Définition des Alias
        $middleware->alias([
            'force.password' => \App\Http\Middleware\ForcePasswordChange::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        \App\Providers\EventServiceProvider::class,
    ])
    ->create(); // <--- UNE SEULE FOIS, TOUT À LA FIN
