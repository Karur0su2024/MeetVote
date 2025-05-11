<?php

namespace App\Http\Middleware\Poll;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CanEdit
{
    // Kontrola, zda má uživatel pravomoci pro úpravu ankety
    public function handle(Request $request, Closure $next): Response
    {
        if(Gate::allows('isAdmin', $request->poll)){
            return $next($request);
        }

        return redirect()->route('polls.show', $request->poll)->with('error', __('pages/poll-show.messages.errors.no_permission_to_access'));
    }
}
