<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HasPassword
{
    // Kontrola, zda je anketa chráněna heslem
    public function handle(Request $request, Closure $next): Response
    {
        if(Gate::allows('hasValidPassword', $request->poll)) {
            return $next($request);
        }

        return redirect()->route('polls.authentication', $request->poll);



    }
}
