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

        // Rozšíření o kontrolu jazyka v session
        // Pokud není jazyk v session, nastavíme ho na základě hlavičky Accept-Language
        if(!session()->has('language')) {
            $lang = substr($request->header('Accept-Language'), 0, 2);
            if(in_array($lang, ['en', 'cs'])) {
                session()->put('language', $lang);
            } else{
                session()->put('language', 'en');
            }
        }
        App::setLocale(session()->get('language'));

        return $next($request);
    }
}
