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

        if (Auth::check() === false) {
            if (session()->has('poll_' . $request->poll->public_id . '_adminKey')) {
                // Porovnání klíče správce ankety z databáze s klíčem uloženým v session
                if (session()->get('poll_' . $request->poll->public_id . '_adminKey') === $request->poll->admin_key) {
                    $this->setPermissions($request);
                }
            }
        } else {
            if ($request->poll->user_id === Auth::id()) {
                $this->setPermissions($request);
            }
        }

        if (!$request->get('isPollAdmin')) {
            // Pokud uživatel není správcem ankety, je přesměrován na stránku s anketou
            if (!$request->routeIs('polls.show')) {
                return redirect()->route('polls.show', $request->poll);
            }
        }


        return $next($request);
    }


    // nastavení práv pro správce ankety
    private function setPermissions($request)
    {
        $request->attributes->add(['isPollAdmin' => true]);
    }
}
