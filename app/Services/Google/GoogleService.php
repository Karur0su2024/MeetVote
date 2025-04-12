<?php

namespace App\Services\Google;


use App\Interfaces\GoogleServiceInterface;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class GoogleService implements GoogleServiceInterface
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client;
        $this->client->setApplicationName(config('app.name'));
        $this->client->setScopes([Calendar::CALENDAR]); // Rozsah přístupu k Google Kalendáři
        $this->client->setAuthConfig(config('google.oauth_credentials')); // Cesta k souboru s oauth credentials
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    public function syncWithGoogleCalendar($users, $event)
    {
        try {
            $event->load('syncedEvents');
            $googleCalendarService = new GoogleCalendarService($this->client);
            $googleEvent = $googleCalendarService->buildGoogleEvent($event);

            foreach ($users as $user) {
                if (!$user->google_id) {
                    continue;
                }
                $this->checkToken($user);
                $googleCalendarService->syncEvent($googleEvent, $event, $user);
            }
        } catch (\Exception $exception) {
            Log::error('Error while syncing event: ' . $exception->getMessage());
        }

    }

    public function desyncWithGoogleCalendar($event)
    {
        try {
            $googleCalendarService = new GoogleCalendarService($this->client);

            foreach ($event->syncedEvents as $syncedEvent) {
                $this->checkToken($syncedEvent->user);
                $googleCalendarService->desyncEvent($syncedEvent->event, $syncedEvent->user->id);
            }

        } catch (\Exception $e) {
            Log::error('Error while desyncing event: ' . $e->getMessage());
        }

    }

    public function checkAvailability($user, $option)
    {
        try {
            $this->checkToken($user);
            $googleCalendarService = new GoogleCalendarService($this->client);
            $events = $googleCalendarService->getCalendarEvents($option) ?? [];
            return count($events) === 0;
        } catch (\Exception $e) {
            Log::error('Error while checking availability: ' . $e->getMessage());
            return null;
        }

    }

    public function checkToken($user)
    {
        try{
            $this->client->setAccessToken($user->google_token); // Přístupový token uživatele
            if ($this->client->isAccessTokenExpired()) {
                $this->refreshToken($user);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    private function refreshToken($user)
    {
        $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token); // Obnovení přístupového tokenu
        $user->google_token = $this->client->getAccessToken();
        $user->save();
    }

}
