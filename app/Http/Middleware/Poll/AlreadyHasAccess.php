<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class AlreadyHasAccess
{
    // Kontrola, zda se uživatel již prokázal heslem
    // Pro případ, kdy chce zobrazit stránku s ověřením heslem
    public function handle(Request $request, Closure $next): Response
    {

        if (Gate::allows('hasValidPassword', $request->poll)) {
            return redirect()->route('polls.show', $request->poll);
        }

        return $next($request);
    }
}
