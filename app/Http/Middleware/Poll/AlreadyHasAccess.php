<?php

namespace App\Http\Middleware\Poll;

use App\Models\Poll;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AlreadyHasAccess
{
    // Kontrola, zda se uživatel již prokázal heslem
    // Pro případ, kdy chce zobrazit stránku s ověřením heslem
    public function handle(Request $request, Closure $next): Response
    {
        $poll = Poll::where('public_id', $request->route('poll'))->firstOrFail();

        if (Gate::allows('hasValidPassword', $poll)) {
            return redirect()->route('polls.show', $poll);
        }

        return $next($request);
    }
}
