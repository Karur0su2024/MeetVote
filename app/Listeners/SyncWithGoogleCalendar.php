<?php

namespace App\Listeners;

use App\Events\PollEventCreated;
use App\Services\Google\GoogleService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        Log::info('Syncing with Google Calendar...', ['poll_id' => $poll->id]);

        try {

            $users = $poll->votes()->with('user')->get()->pluck('user')->unique()->filter();
            $event = $poll->event;
            $this->googleService->syncWithGoogleCalendar($users, $event);
        } catch (\Exception $e) {
            Log::error('Error while syncing calendar: ' . $e->getMessage());
        }

    }
}
