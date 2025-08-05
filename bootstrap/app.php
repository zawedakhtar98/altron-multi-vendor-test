<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\SellerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [
            \Illuminate\Auth\Middleware\Authenticate::class,// must be logged in
            AdminMiddleware::class,
        ]);

        $middleware->group('seller', [
            \Illuminate\Auth\Middleware\Authenticate::class,
            SellerMiddleware::class,
        ]);

        $middleware->group('customer', [
            \Illuminate\Auth\Middleware\Authenticate::class,
            CustomerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
