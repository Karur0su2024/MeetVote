<?php

namespace App\Listeners;

use App\Services\Google\GoogleService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DesyncCalendarEvent
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
    public function handle(object $event): void
    {
        $poll = $event->poll;
        $poll->load('event');
        $this->googleService->desyncWithGoogleCalendar($poll->event);

        if ($poll->event) $poll->event->delete();
    }
}
