<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfConnectedToGoogle
{
    // Kontrola, zda je uživatel připojen k Google
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if(!$user->google_id) {
            return redirect()->back()->withErrors(['error' => 'You are not connected to Google.']);
        }


        return $next($request);
    }
}
