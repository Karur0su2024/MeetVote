<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    // Kontrola, zda je anketa aktivní
    public function handle(Request $request, Closure $next): Response
    {
        if($request->poll->isActive()){
            return $next($request);
        }

        return redirect()->route('polls.show', $request->poll)->with('error', __('pages/poll-show.messages.errors.not_active'));
    }
}
