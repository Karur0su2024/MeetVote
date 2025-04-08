<?php

namespace App\Listeners;

use App\Events\VoteSubmitted;
use App\Services\Mail\EmailService;

class SendVoteNotificationEmail
{
    protected EmailService $notificationService;
    /**
     * Create the event listener.
     */
    public function __construct(EmailService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(VoteSubmitted $event): void
    {
        $vote = $event->vote;

        $this->notificationService->sendVoteNotificationEmail($vote->poll, $vote);
    }
}
