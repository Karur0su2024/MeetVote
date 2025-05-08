<?php

namespace App\Services\Google;


use App\Interfaces\GoogleServiceInterface;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Gate;
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

    // Synchronizace události s Google Kalendářem
    public function syncWithGoogleCalendar($users, $event)
    {
        try {
            $event->load('syncedEvents');
            $googleCalendarService = new GoogleCalendarService($this->client);
            $googleEvent = $googleCalendarService->buildGoogleEvent($event);

            foreach ($users as $user) {
                if (Gate::denies('sync', $user)) {
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

    public function checkAvailability($user, $timeOptions)
    {
        try {
            $googleCalendarService = new GoogleCalendarService($this->client);
            foreach ($timeOptions as $optionIndex => &$option) {
                if ($option['invalid'] ?? false) {
                    continue;
                }
                $this->checkToken($user);
                $events = $googleCalendarService->getCalendarEvents($option) ?? [];
                $option['availability'] = count($events) === 0;
            }


            return $timeOptions;
        } catch (\Exception $e) {
            Log::error('Error while checking availability: ' . $e->getMessage());
            return $timeOptions;
        }

    }

    public function checkToken($user)
    {
        try {
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
