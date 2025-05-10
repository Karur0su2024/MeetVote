<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    // Nastavení jazyka uloženého v session
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale(session()->get('language', 'en'));

        return $next($request);
    }
}
