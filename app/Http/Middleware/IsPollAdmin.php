<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IsPollAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && $request->poll->user_id === Auth::id()) {
            $this->setPermissions($request);
        }

        if (session()->has('poll_'.$request->poll->public_id.'_adminKey')) {
            // Porovnání klíče správce ankety z databáze s klíčem uloženým v session
            if (session()->get('poll_'.$request->poll->public_id.'_adminKey') === $request->poll->admin_key) {
                $this->setPermissions($request);
            }
        }


        if (!$request->get('isPollAdmin')) {
            // Pokud uživatel chce přistupovat např. na stránku editace ankety, ale není správce ankety
            // je přesměrován na stránku ankety
            if (! $request->routeIs('polls.show')) {
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
