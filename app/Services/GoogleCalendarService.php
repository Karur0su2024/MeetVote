<?php

namespace App\Services;

use App\Models\SyncedEvent;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleCalendarService
{
    public function __construct()
    {
        $this->client = new Client;
        $this->client->setApplicationName('MeetVote');
        $this->client->setScopes(Calendar::CALENDAR); // Rozsah přístupu k Google Kalendáři
        $this->client->setAuthConfig(storage_path('app/oauth-credentials.json')); // Cesta k souboru s oauth credentials
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    function synchronizeGoogleCalendar($users, $pollEvent)
    {
        foreach ($users as $user) {
            try {
                $this->refreshToken($user, $this->client); // Obnovení Google tokenu uživatele
                $this->addEventToCalendar($pollEvent, $this->client, $user); // Přidání události do Google Kalendáře
            }
            catch (\Exception $e) {
                continue; // Pokračování na dalšího uživatele
            }

        }
    }

    public function deleteEvent($event){
        $syncEvents = $event->syncedEvents; // Získání všech synchronizovaných událostí
        foreach($syncEvents as $syncEvent){

            $this->refreshToken($syncEvent->user, $this->client); // Obnovení Google tokenu uživatele

            $calendar = new Calendar($this->client); // Inicializace Google Kalendáře

            try {
                $calendar->events->get('primary', $syncEvent->calendar_event_id); // Získání události z Google Kalendáře
                $calendar->events->delete('primary', $syncEvent->calendar_event_id); // Smazání události z Google Kalendáře
            } catch (\Exception $e) {
                // Zpracování chyby, pokud událost neexistuje
            }
            $syncEvent->delete(); // Smazání synchronizované události z databáze
        }
        $event->delete(); // Smazání události z databáze
    }

    private function createNewEvent($event, $calendar, $user, $pollEvent){
        $calendarEvent = $calendar->events->insert('primary', $event);
        SyncedEvent::create([
            'calendar_event_id' => $calendarEvent->id, // ID události v Google Kalendáři
            'event_id' => $pollEvent->id,
            'user_id' => $user->id,
        ]);
    }


    private function buildEvent($pollEvent)
    {
        $description = $pollEvent->description;
        $description .= "\n\nPoll link: " . route('polls.show', ['poll' => $pollEvent->poll->public_id]); // Odkaz na anketu

        return new Event([
            'summary' => 'MeetVote: ' . $pollEvent->title, // Název události
            'description' => $description, // Popis události
            'start' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($pollEvent->start_time)),
                'timeZone' => 'Europe/Prague',
            ],
            'end' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($pollEvent->end_time)),
                'timeZone' => 'Europe/Prague',
            ],
        ]);

    }

    private function addEventToCalendar($pollEvent, $client, $user)
    {
        $calendar = new Calendar($client); // Inicializace Google Kalendáře
        $event = $this->buildEvent($pollEvent); // Vytvoření události

        $calendarEvent = SyncedEvent::where('event_id', $pollEvent->id) // Kontrola, zda synchronizovaná událost již existuje
        ->where('user_id', $user->id)
            ->first();

        if($calendarEvent){
            try {
                $calendar->events->get('primary', $calendarEvent->calendar_event_id); // Získání události z Google Kalendáře
                $calendar->events->update('primary', $calendarEvent->calendar_event_id, $event); // Aktualizace události
            }
            catch (\Exception $e) {
                $calendarEvent->delete(); // Smazání události z databáze, pokud již neexistuje v Google Kalendáři
                $this->createNewEvent($event, $calendar, $user, $pollEvent);
            }
        }
        else {
            $this->createNewEvent($event, $calendar, $user, $pollEvent);
        }

    }

    private function refreshToken($user, $client)
    {
        $client->setAccessToken($user->google_token); // Přístupový token uživatele

        if ($client->isAccessTokenExpired()) {
            if ($user->google_refresh_token) {
                $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token); // Obnovení přístupového tokenu
                $user->google_token = $client->getAccessToken();
                $user->save();
                $client->setAccessToken($user->google_token);
            }
            else {
                return false;
            }
        }
        return true;

    }

}
