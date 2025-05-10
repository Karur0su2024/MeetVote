<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SetTimezone
{
    // Nastavení časového pásma na základě nastavení ankety
    public function handle(Request $request, Closure $next): Response
    {
        date_default_timezone_set($request->poll->timezone);
        return $next($request);
    }
}
