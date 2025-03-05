<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPollPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kontrola, zda je uživatel autorizován
        if(session('poll_' . $request->poll->public_id . 'admin_key') !== $request->poll->admin_key) {
            dd('Nemáte přístup');
            if($request->poll->password !== null) {
                if(!session()->has('poll_' . $request->poll->public_id . '_password')) {
                    return redirect()->route('polls.authentification', $request->poll);
                }
                else {
                    if($request->poll->password !== session('poll_' . $request->poll->public_id . '_password')) {
                        return redirect()->route('polls.authentification', $request->poll);
                    }
                }
            }
        }






        //dd(session('poll_' . $request->poll->public_id . '_password'));

        return $next($request);
    }
}
