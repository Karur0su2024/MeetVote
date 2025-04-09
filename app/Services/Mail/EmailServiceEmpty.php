<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;

class EmailServiceEmpty implements EmailServiceInterface
{

    public function sendConfirmationEmail($poll)
    {
        return;
    }

    public function sendInvitation($email, $poll, $key)
    {
        return;
    }

    public function sendVoteNotificationEmail($poll, $vote)
    {
        return;
    }
}
