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

        if($request->get('isPollAdmin') || $request->get('haveInvitation')) {
            return $next($request);
        }

        // Kontrola, zda je uživatel autorizován
        if ($request->poll->password !== '') {

            // Kontrola, zda uživatel heslo již zadal
            if (session('poll_'.$request->poll->public_id.'_password') === $request->poll->password) {
                return $next($request);
            }

            if (! session()->has('poll_'.$request->poll->public_id.'_password')) {
                return redirect()->route('polls.authentification', $request->poll);
            } else {
                // Kontrola, zda je uložené heslo v session shodné s heslem v databázi
                // Kontrola, zda nebylo změněno heslo
                if ($request->poll->password !== session('poll_'.$request->poll->public_id.'_password')) {
                    return redirect()->route('polls.authentification', $request->poll);
                }
            }
        }


        return $next($request);
    }
}
