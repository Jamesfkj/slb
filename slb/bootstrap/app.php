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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'=> App\Http\Middleware\admin::class,
            'adminAccess'=> App\Http\Middleware\adminAccess::class,
            'commander'=> App\Http\Middleware\commander::class,
            'panier'=> App\Http\Middleware\panier::class,
            'compte_supprime' => App\Http\Middleware\compte_bani::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
