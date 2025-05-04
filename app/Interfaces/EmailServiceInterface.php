<?php

namespace App\Interfaces;

use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;

interface EmailServiceInterface
{
    public function sendPollConfirmationEmail($poll);

    public function sendVoteNotificationEmail($poll, $vote);

    public function sendInvitation($email, $poll, $key);

    public function sendRegistrationMail($user);
}
