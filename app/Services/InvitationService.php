<?php

namespace App\Services;


use App\Models\Invitation;
use App\Models\Poll;

class InvitationService
{

    function checkInvitation($token): Poll
    {
        $invitation = Invitation::where('key', $token)->firstOrFail();

        $poll = Poll::where('id', $invitation->poll_id)->firstOrFail();

        if($invitation->status === 'pending') {
            $invitation->status = 'active';
            $invitation->save();
        }

        session()->push('poll_invitations.'.$poll->id, $token);

        return $poll;
    }


}
