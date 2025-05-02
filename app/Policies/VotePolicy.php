<?php

namespace App\Policies;

use App\Models\Vote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VotePolicy
{
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

    public function view(?User $user, Vote $vote): bool {

        // Přidat podmínku zda jsou výsledky skryté

        if(auth()->check()) {
            if ($vote->user_id === $user->id) {
                return true;
            }
        }
        if ($vote->poll->anonymous_votes) {
            return false;
        }

        if(Gate::allows('isAdmin', $vote->poll)) {
            return true;
        }

        return false;
    }


}
