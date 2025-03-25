<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use App\Enums\PollStatus;

class PollPolicy
{
    public function isAdmin(?User $user, Poll $poll): bool
    {
        if (($user !== null) && $poll->user_id === $user->id) {
            return true;
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
        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        if ($poll->password !== null) {
            return session()->get('poll_' . $poll->public_id . '_authenticated', false) === true;
        }

        return true;
    }



    public function canVote(?User $user, Poll $poll): bool
    {
        return $poll->isActive();

    }

    public function addOption(?User $user, Poll $poll): bool
    {
        if(!$poll->isActive()) {
            return false;
        }

        return $poll->add_time_options || $this->isAdmin($user, $poll);
    }


    public function close(?User $user, Poll $poll): bool
    {
        if ($poll->votes()->count() === 0) {
            return false;
        }

        if (!$this->isAdmin($user, $poll)) {
            return false;
        }

        if ($poll->isActive()) {
            return $poll->votes()->count() > 0;
        }

        return false;
    }



    public function edit(?User $user, Poll $poll): bool
    {
        if (!$poll->isActive()){
            return false;
        }

        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return $poll->user_id === $user->id;
    }

    public function invite(?User $user, Poll $poll): bool
    {
        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return false;
    }


    public function createEvent(?User $user, Poll $poll): bool
    {
        if(!$poll->isActive()) {
            return false;
        }

        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return false;
    }

}
