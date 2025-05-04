<?php

namespace App\Listeners;

use App\Events\PollCreated;
use App\Services\Mail\EmailService;

class SendPollConfirmationEmail
{
    protected EmailService $emailService;

    /**
     * Create the event listener.
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     */
    public function handle(PollCreated $event): void
    {

        $poll = $event->poll;

        if($poll->author_email){
            $this->emailService->sendPollConfirmationEmail($poll);
        }
    }
}
