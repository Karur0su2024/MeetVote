<?php

namespace App\Http\Middleware;

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
            'setLanguage' => SetLanguage::class,
            'checkIfConnectedToGoogle' => CheckIfConnectedToGoogle::class,
            'poll.has_access' => Poll\HasAccess::class,
            'poll.is_active' => Poll\IsActive::class,
            'poll.is_invite_only' => Poll\IsInviteOnly::class,
            'poll.has_password' => Poll\HasPassword::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
