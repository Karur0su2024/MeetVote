<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Poll;

class PollExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        /*

        $poll = Poll::where('public_id', $request->route('poll_id'))->first();


        if (!$poll) {
            return redirect()->route('home')->with('error', 'Poll not found.');
        }

        $request->attributes->set('poll', $poll);

        $request->merge(['poll' => $request->get('poll')]);*/

        return $next($request);
    }
}
