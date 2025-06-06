<?php

namespace App\Policies;

use App\Models\Vote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VotePolicy
{
    // Kontroluje zda uživatel může změnit odpověď
    public function edit(?User $user, Vote $vote): bool
    {


        if (!$vote->poll->isActive()) {
            return true;
        }

        if(!Auth::check()) {
            return false;
        }

        return true;

    }

    // Kontroluje zda uživatel může smazat odpověď
    public function delete(?User $user, Vote $vote): bool
    {
        if(!$vote->poll->isActive()){
            return false;
        }
        if(Gate::allows('hasAdminPermissions', $vote->poll)) {
            return true;
        }

        return $user && $vote->user_id === $user->id;
    }

    // Kontroluje zda uživatel může zobrazit odpověď
    public function view(?User $user, Vote $vote): bool {

        // Přidat podmínku zda jsou výsledky skryté

        if(auth()->check()) {
            if ($vote->user_id === $user->id) {
                return true;
            }
        }

        if(session()->get('poll.' . $vote->poll->id . '.vote') === $vote->id) {
            return true;
        }

        return $vote->poll->settings['anonymous_votes'];
    }


}
