<?php

namespace App\Policies;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class PollPolicy
{
    public function isAdmin(User $user, Poll $poll): bool
    {
        return session()->get('poll_' . $poll->public_id . '_adminKey') === $poll->admin_key;
    }

    public function canVote(User $user, Poll $poll): bool
    {
        return $poll->isActive();
    }

}
