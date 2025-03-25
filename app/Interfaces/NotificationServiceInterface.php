<?php

namespace App\Interfaces;

use App\Mail\PollCreatedConfirmationEmail;
use App\Mail\VoteNotificationEmail;
use Illuminate\Support\Facades\Mail;

interface NotificationServiceInterface
{
    public function sendConfirmationEmail($poll);

    public function voteNotification($poll, $vote);

    public function sendInvitation($email, $poll, $key);

}
