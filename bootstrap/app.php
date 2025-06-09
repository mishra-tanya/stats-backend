<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: [
                __DIR__.'/../routes/api_db1.php',
                __DIR__.'/../routes/api_db2.php',
                __DIR__.'/../routes/api_db3.php',
                __DIR__.'/../routes/api_db4.php',
            ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions() 
    ->withBindings([
            Illuminate\Contracts\Debug\ExceptionHandler::class => App\Exceptions\Handler::class,
        ])
    ->create();
