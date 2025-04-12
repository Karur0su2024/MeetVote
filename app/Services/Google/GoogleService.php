<?php

namespace App\Services\Google;


use App\Interfaces\GoogleServiceInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

/**
 *
 */
class GoogleService implements GoogleServiceInterface
{


    public function syncWithGoogleCalendar($users, $event)
    {

        $googleCalendarService = new GoogleCalendarService();
        app()->instance(GoogleCalendarService::class, $googleCalendarService);

        $event->load('syncedEvents');

        try {
            $googleEvent = $googleCalendarService->buildGoogleEvent($event);

            foreach ($users as $user) {
                if (!$user->google_id) {
                    continue;
                }
                $googleCalendarService->checkToken($user);
                $googleCalendarService->desyncEvent($event, $user->id);

                $googleCalendarService->syncEvent($googleEvent, $event, $user);
            }
        } catch (\Exception $exception) {
            Log::error('Error while syncing event: ' . $exception->getMessage());
        }

    }

    public function desyncWithGoogleCalendar($event)
    {

        try {
            $googleCalendarService = new GoogleCalendarService();

            $syncedEvents = $event->syncedEvents;

            foreach ($syncedEvents as $syncedEvent) {
                $googleCalendarService->checkToken($syncedEvent->user);
                $googleCalendarService->desyncEvent($syncedEvent->event, $syncedEvent->user->id);
            }

        } catch (\Exception $e) {
            Log::error('Error while desyncing event: ' . $e->getMessage());
        }

    }

    public function checkAvailability($user, $option)
    {
        try {
            $startTime = $option['date'] . ' ' . ($option['content']['start'] ?? '');
            $endTime = $option['date'] . ' ' . ($option['content']['end'] ?? '');

            $googleCalendarService = new GoogleCalendarService();
            $googleCalendarService->checkToken($user);

            $start = date('c', strtotime($startTime));
            $end = date('c', strtotime($endTime));

            $events = $googleCalendarService->getEvents($start, $end) ?? [];

            return count($events) === 0;
        } catch (\Exception $e) {
            Log::error('Error while checking availability: ' . $e->getMessage());
            return null; // V případě chyby vrátíme null (neznámý stav)
        }

    }
}
