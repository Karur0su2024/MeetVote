<?php

namespace App\Listeners;

use App\Events\PollEventCreated;
use App\Services\Google\GoogleService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncWithGoogleCalendar
{

    protected GoogleService $googleService;
    /**
     * Create the event listener.
     */
    public function __construct(GoogleService $googleService)
    {
        $this->googleService = $googleService;
    }

    /**
     * Handle the event.
     */
    public function handle(PollEventCreated $pollEventCreated): void
    {
        $poll = $pollEventCreated->poll;
        $users = $poll->votes()->with('user')->get()->pluck('user')->unique()->filter();
        $event = $poll->event;
        $this->googleService->syncWithGoogleCalendar($users, $event);
    }
}
