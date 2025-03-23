<?php

namespace App\Http\Middleware\Poll;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsInviteOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Gate::allows('hasValidInvitation', $request->poll)){
            return $next($request);
        }
        // vytvořit stránku pro upozornění, že je potřeba pozvánka
        return redirect()->route('home', $request->poll);
    }

}
