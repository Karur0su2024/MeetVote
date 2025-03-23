<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->poll->isActive()){
            return $next($request);
        }

        return redirect()->route('polls.show', $request->poll)->with('error', 'You can\'t do this because the poll is not active or it has already ended.');
    }
}
