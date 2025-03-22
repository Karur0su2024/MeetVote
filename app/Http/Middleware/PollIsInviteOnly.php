<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollIsInviteOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //dd($request->get('isPollAdmin'));

        // Kontrola, zda má uživatel práva správce ankety, je kontrola přeskočena
        if ($request->get('isPollAdmin')) {
            return $next($request);
        }

        //dd(session()->get('poll_' . $request->poll->public_id . '_invite'));

        // Získání klíče pozvánky
        if (session()->has('poll_' . $request->poll->public_id . '_invite')) {
            $invite_key = session()->get('poll_' . $request->poll->public_id . '_invite');
            $invitation = Invitation::where('poll_id', $request->poll->id)->where('key', $invite_key)->first();
            if ($invitation) {
                if ($invitation->status === 'active') {
                    $this->setPermissions($request);
                    return $next($request);
                }
            }
        }

        // Kontrola, zda je anketa nastavena jako "pouze na pozvání"
        if ($request->poll->invite_only) {
            if(!$request->has('haveInvitation')) {
                // Vytvořit jinou stránku pro přesměrování
                return redirect()->route('home', $request->poll);
            }
        }

        return $next($request);
    }

    private function setPermissions($request)
    {
        $request->attributes->add(['haveInvitation' => true]);
    }
}
