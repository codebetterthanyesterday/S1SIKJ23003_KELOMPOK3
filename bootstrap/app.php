<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias route middleware
        $middleware->alias([
            // middleware 'auth' untuk memastikan user sudah login
            'auth'  => Authenticate::class,
            // middleware 'guest' untuk mencegah user yang sudah login mengakses halaman guest
            'guest' => RedirectIfAuthenticated::class,
            // middleware 'role' untuk memeriksa peran user
            'role'  => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
