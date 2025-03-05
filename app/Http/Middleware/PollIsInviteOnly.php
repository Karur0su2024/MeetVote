<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Invitation;

class PollIsInviteOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        
        if(session()->has('poll_' . $request->poll->public_id . 'adminKey')) {
            return $next($request);
        }


        if($request->poll->invite_only) {
            // Kontrola, zda je v session uložen klíč pozvánky
            if(!session()->has('poll_' . $request->poll->public_id . '_invite')) {
                return redirect()->route('home', $request->poll);
            }
            else {

                // Získání klíče pozvánky z session
                $invite_key = session()->get('poll_' . $request->poll->public_id . '_invite');

                // Získání pozvánky z databáze
                $invitation = Invitation::where('poll_id', $request->poll->id)->where('key', $invite_key)->first();

                // Kontrola, zda je pozvánka platná
                if($invitation === null) {
                    return redirect()->route('home', $request->poll);
                }
                else {
                    // Kontrola, zda není pozvánka deaktivovaná
                    if($invitation->status === 'deactivated') {
                        return redirect()->route('home', $request->poll);
                    }
                }
            }
        }

        return $next($request);
    }
}
