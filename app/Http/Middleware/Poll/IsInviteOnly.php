<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class IsInviteOnly
{
    // Kontrola, zda je anketa pouze pro pozvané
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::allows('hasValidInvitation', $request->poll)) {
            return $next($request);
        }

        // vytvořit stránku pro upozornění, že je potřeba pozvánka
        return redirect()->route('home', $request->poll);
    }
}
