<?php

namespace App\Services\Mail;

use App\Interfaces\EmailServiceInterface;
use Illuminate\Support\Facades\Log;

class EmailServiceEmpty implements EmailServiceInterface
{

    public function sendConfirmationEmail($poll): void
    {
        Log::info('Email service is disabled, not sending confirmation email');
    }


    public function sendInvitation($email, $poll, $key): void
    {
        Log::info('Email service is disabled, not sending invitation email');
    }

    public function sendVoteNotificationEmail($poll, $vote): void
    {
        Log::info('Email service is disabled, not sending vote notification email');
    }


    public function sendRegistrationMail($user): void
    {
        Log::info('Email service is disabled, not sending registration email');
    }
}
