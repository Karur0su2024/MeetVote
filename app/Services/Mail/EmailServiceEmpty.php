<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;
use Illuminate\Support\Facades\Log;

class EmailServiceEmpty implements EmailServiceInterface
{

    public function sendConfirmationEmail($poll)
    {
        Log::info('Email service is disabled, not sending confirmation email');
        return;
    }

    public function sendInvitation($email, $poll, $key)
    {
        Log::info('Email service is disabled, not sending invitation email');
        return;
    }

    public function sendVoteNotificationEmail($poll, $vote)
    {
        Log::info('Email service is disabled, not sending vote notification email');
        return;
    }
}
