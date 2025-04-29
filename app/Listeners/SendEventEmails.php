<?php

namespace App\Listeners;

use App\Events\PollEventCreated;
use App\Interfaces\EmailServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEventEmails
{
    /**
     * Create the event listener.
     */
    public function __construct(public EmailServiceInterface $emailService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PollEventCreated $pollEventCreated): void
    {

        $poll = $pollEventCreated->poll;

        foreach ($poll->votes as $vote) {
            $this->emailService->sendEventNotification($vote->voter_email, $poll->event);
        }

    }
}
