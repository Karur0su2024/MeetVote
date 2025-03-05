<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPollAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        // Kontrola, zda je uživatel vlastníkem ankety
        if($request->poll->user_id === Auth::id()) {
            $this->setPermissions($request);
        }
        else {
            // Kontrola, zda je v session uložen klíč správce ankety
            if(session()->has('poll_' . $request->poll->public_id . 'adminKey')) {
                // Porovnání klíče správce ankety z databáze s klíčem uloženým v session
                if(session()->get('poll_' . $request->poll->public_id . 'adminKey') === $request->poll->admin_key) {
                    $this->setPermissions($request);
                }
            }
        }




        return $next($request);
    }


    // nastavení práv pro správce ankety
    private function setPermissions($request) {
        $request->attributes->add(['isPollAdmin' => true]);
    }
}
