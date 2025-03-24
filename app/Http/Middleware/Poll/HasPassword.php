<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class HasPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Gate::allows('hasValidPassword', $request->poll)){
            return $next($request);
        }

        dd('HasPassword middleware', $request->poll->password, session('poll_'.$request->poll->public_id.'_authenticated', false));
        return redirect()->route('polls.authentication', $request->poll);



    }
}
