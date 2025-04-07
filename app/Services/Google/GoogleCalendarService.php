<?php

namespace App\Services\Google;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    protected $client;
    protected $calendar;

    public function __construct()
    {
        $this->client = new Client;
        $this->client->setApplicationName(config('app.name'));
        $this->client->setScopes(Calendar::CALENDAR); // Rozsah přístupu k Google Kalendáři
        $this->client->setAuthConfig(config('google.oauth_credentials')); // Cesta k souboru s oauth credentials
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->calendar = new Calendar($this->client); // Inicializace Google Kalendáře
    }

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    public function syncEvent($googleEvent, $event, $user)
    {
        $calendarEvent = $this->calendar->events->insert('primary', $googleEvent);
        $event->syncedEvents()->create([
            'calendar_event_id' => $calendarEvent->id, // ID události v Google Kalendáři
            'user_id' => $user->id,
        ]);

    }

    public function desyncEvent($event, $userIndex)
    {
        $syncEvent = $event->syncedEvents->where('user_id', $userIndex)->first();
        try {
            $this->calendar->events->get('primary', $syncEvent->calendar_event_id); // Získání události z Google Kalendáře
            $this->calendar->events->delete('primary', $syncEvent->calendar_event_id); // Smazání události z Google Kalendáře
        } catch (\Exception $e) {
            //dd($e->getMessage());
        }

        if($syncEvent) {
            $syncEvent->delete();
        }

    }

    private function refreshToken($user)
    {
        $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token); // Obnovení přístupového tokenu
        $user->google_token = $this->client->getAccessToken();
        $user->save();
    }

    public function checkToken($user)
    {
        $this->client->setAccessToken($user->google_token); // Přístupový token uživatele

        if ($this->client->isAccessTokenExpired()) {
            $this->refreshToken($user);
        }
        return true;
    }

    public function buildGoogleEvent($event)
    {
        $description = $event->description;
        $description .= "\n\nPoll link: " . route('polls.show', ['poll' => $event->poll->public_id]); // Odkaz na anketu

        $googleEvent = new Event([
            'summary' => 'MeetVote: ' . $event->title,
            'description' => $description,
            'start' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($event->start_time)),
                'timeZone' => 'Europe/Prague',
            ],
            'end' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($event->end_time)),
                'timeZone' => 'Europe/Prague',
            ],
        ]);

        return $googleEvent;

    }


    public function getEvents($startTime, $endTime)
    {
        $calendarId = 'primary';
        $eventDetails = [
            'timeMin' => $startTime,
            'timeMax' => $endTime,
            'singleEvents' => true,
            'timeZone' => date_default_timezone_get(),
        ];
        return $this->calendar->events->listEvents($calendarId, $eventDetails)->getItems();

    }


}
