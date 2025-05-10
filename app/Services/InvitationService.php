<?php

namespace App\Services;


use App\Models\Invitation;
use App\Models\Poll;

class InvitationService
{

    // Kontrola pozvánky
    function checkInvitation($token): Poll
    {
        $invitation = Invitation::where('key', $token)->firstOrFail();

        $poll = Poll::where('id', $invitation->poll_id)->firstOrFail();

        if($invitation->status === 'pending') {
            $invitation->status = 'active';
            $invitation->save();
        }

        session()->put('poll_invitations.'.$poll->id, $token);

        return $poll;
    }


}
