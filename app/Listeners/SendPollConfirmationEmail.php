<?php

namespace App\Listeners;

use App\Events\PollCreated;
use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPollConfirmationEmail
{
    protected EmailService $emailService;

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
    public function handle(PollCreated $event): void
    {

        $poll = $event->poll;

        if($poll->author_email){
            $this->emailService->sendConfirmationEmail($poll);
        }
    }
}
