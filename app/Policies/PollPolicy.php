<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use App\Enums\PollStatus;

class PollPolicy
{

    public function isOwner(?User $user, Poll $poll): bool
    {
        return $user && $poll->user_id === $user->id;
    }

    public function hasValidKey(?User $user, Poll $poll): bool
    {
        return (session()->get('poll_admin_keys.' . $poll->id . '.0', null) === $poll->admin_key);
    }

    public function isAdmin(?User $user, Poll $poll): bool
    {
        return $this->hasValidKey($user, $poll) || $this->isOwner($user, $poll);
    }

    public function hasAdminPermissions(?User $user, Poll $poll): bool
    {
        return $this->hasValidKey($user, $poll) || $this->isOwner($user, $poll);
    }

    public function hasValidInvitation(?User $user, Poll $poll): bool
    {
        if ($this->hasAdminPermissions($user, $poll)) return true;

        if ($poll->invite_only) {
            $invitationKey = session()->get('poll_invitations.' . $poll->id);

            return $poll->invitations->where('key', $invitationKey)->isNotEmpty();
        }

        return true;
    }

    public function hasValidPassword(?User $user, Poll $poll): bool
    {
        if ($this->hasAdminPermissions($user, $poll)) return true;

        if ($poll->password !== null) {
            return session()->get('poll_passwords.'.$poll->id)[0] ?? null === $poll->password;
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

        return true;
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
        if($poll->isActive()) {
            return false;
        }

        if ($this->isAdmin($user, $poll)) {
            return true;
        }

        return false;
    }

}
