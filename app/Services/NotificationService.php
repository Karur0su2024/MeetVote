<?php

namespace App\Services;

use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{


    // Potvrzení vytvoření ankety
    public function sendConfirmationEmail($poll)
    {
        Mail::to($poll->author_email)->send(new PollCreatedConfirmationEmail($poll));
    }


    public function voteNotification($poll, $vote)
    {
        // Odeslání e-mailu uživateli
        Mail::to($poll->author_email)->send(new VoteNotificationEmail($poll, $vote));
    }


}
