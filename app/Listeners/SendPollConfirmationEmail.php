<?php

namespace App\Listeners;

use App\Events\PollCreated;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPollConfirmationEmail
{
    protected NotificationService $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
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
            $this->notificationService->sendConfirmationEmail($poll);
        }
    }
}
