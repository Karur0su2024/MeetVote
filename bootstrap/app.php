<?php

use App\Http\Middleware\CheckPollPassword;
use App\Http\Middleware\IsPollAdmin;
use App\Http\Middleware\PollIsInviteOnly;
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
            'checkPassword' => CheckPollPassword::class,
            'isPollAdmin' => IsPollAdmin::class,
            'inviteOnly' => PollIsInviteOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
