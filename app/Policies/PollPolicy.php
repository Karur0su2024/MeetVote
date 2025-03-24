<?php

namespace App\Policies;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class PollPolicy
{
    public function isAdmin(?User $user, Poll $poll): bool
    {
        if ($user !== null) {
            if ($poll->user_id === $user->id) {
                return true;
            }
        }


        return session()->get('poll_' . $poll->public_id . '_adminKey') === $poll->admin_key;
    }

    public function hasValidInvitation(?User $user, Poll $poll): bool
    {
        if ($this->isAdmin($user, $poll)) return true;

        if ($poll->invite_only) {
            return $poll->invitations->where('key', session()->get('poll_' . $poll->public_id . '_invite'))->isNotEmpty();
        }

        return true;
    }

    public function hasValidPassword(?User $user, Poll $poll): bool
    {
        if ($this->isAdmin($user, $poll)) return true;

        if ($poll->password !== '') {
            return session()->get('poll_' . $poll->public_id . '_authenticated', false) === true;
        }

        return true;
    }



    public function canVote(?User $user, Poll $poll): bool
    {
        return $poll->isActive();

    }

    public function canAddOption(?User $user, Poll $poll): bool
    {
        return $poll->add_time_options || $this->isAdmin($user, $poll);
    }

}
