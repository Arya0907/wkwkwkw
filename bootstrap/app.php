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
            'isLogin' => \App\Http\Middleware\IsLogin::class,
            'isNotLogin' => \App\Http\Middleware\IsNotLogin::class,
            'isStaff' => \App\Http\Middleware\IsStaff::class,
            'isHeadStaff' =>\App\Http\Middleware\IsHeadStaff::class,
            'isGuest' => \App\Http\Middleware\IsGuest::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
