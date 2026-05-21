<?php

namespace App\Interfaces;

interface EmailServiceInterface
{
    public function sendPollConfirmationEmail($poll);

    public function sendVoteNotificationEmail($poll, $vote);

    public function sendInvitation($email, $poll, $key);

    public function sendRegistrationMail($user);

    public function sendEventNotification($email, $event);
}
