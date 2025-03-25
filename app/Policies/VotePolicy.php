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

        if(!$vote->poll->edit_votes){
            return false;
        }

        if(Gate::allows('isAdmin', $vote->poll)) {
            return true;
        }

        return $user && $vote->user_id === $user->id;

    }

    public function delete(?User $user, Vote $vote): bool
    {
        if(Gate::allows('isAdmin', $vote->poll)) {
            return true;
        }

        return $user && $vote->user_id === $user->id;
    }

    public function view(?User $user, Vote $vote, bool $isAdmin): bool {

        // Přidat podmínku zda jsou výsledky skryté

        if ($isAdmin) {
            return true;
        }

        if ($vote->user_id === Auth::user()->id) {
            return true;
        }

        return false;
    }


}
