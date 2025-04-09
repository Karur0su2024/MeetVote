<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;
use App\Mail\InvitationEmail;
use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;

class EmailService implements EmailServiceInterface
{

    // Potvrzení vytvoření ankety
    public function sendConfirmationEmail($poll)
    {
        //Mail::to($poll->author_email)->send(new PollCreatedConfirmationEmail($poll));
    }


    public function sendVoteNotificationEmail($poll, $vote)
    {
        //        if($poll->notifications){
        //            TODO: doplnit vypnutí notifikací
        //        }
        //Mail::to($poll->author_email)->send(new VoteNotificationEmail($poll, $vote));
    }

    public function sendInvitation($email, $poll, $key)
    {

        //Mail::to($email)->send(new InvitationEmail($poll, $key));
    }

}
