<?php

namespace App\Services;

use App\Mail\InvitationEmail;
use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{

    // Potvrzení vytvoření ankety
    public function sendConfirmationEmail($poll)
    {
        if(!$this->isEmailConfigured()) return;

        Mail::to($poll->author_email)->send(new PollCreatedConfirmationEmail($poll));
    }


    public function voteNotification($poll, $vote)
    {
        if(!$this->isEmailConfigured()) return;
        // Odeslání e-mailu uživateli
        Mail::to($poll->author_email)->send(new VoteNotificationEmail($poll, $vote));
    }

    public function sendInvitation($email, $poll, $key)
    {
        if(!$this->isEmailConfigured()) return;
        // Odeslání e-mailu uživateli
        //Mail::to($email)->send(new InvitationEmail($poll, $key));
    }

    private function isEmailConfigured(): bool
    {
        $isAllowed = config('mail.mail_allowed');
        $host = config('mail.mailers.smtp.host');
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');

        // Pokud chybí některá klíčová hodnota, e-maily se nebudou odesílat
        return $isAllowed && (!empty($host) || !empty($username) || !empty($password));
    }


}
