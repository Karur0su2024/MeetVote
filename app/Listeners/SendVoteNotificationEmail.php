<?php

namespace App\Listeners;

use App\Events\VoteSubmitted;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVoteNotificationEmail
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
    public function handle(VoteSubmitted $event): void
    {
        $vote = $event->vote;

        $this->notificationService->voteNotification($vote->poll, $vote);
    }
}
