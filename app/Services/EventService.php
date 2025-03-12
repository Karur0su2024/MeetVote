<?php

namespace App\Services;

use App\Models\SyncedEvent;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class EventService
{

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    function synchronizeGoogleCalendar($users, $pollEvent)
    {
        $client = new Client();
        $client->setApplicationName('MeetVote');
        $client->addScope(Calendar::CALENDAR); // Přístup k událostem kalendáře
        $client->setClientId(config('services.google.client_id')); // ID klienta
        $client->setClientSecret(config('services.google.client_secret')); // Tajný klíč klienta


        foreach ($users as $user) {
            // Vytvoření Google Client
            $client->setAccessToken($user->google_token); // Přístupový token uživatele

            if ($client->isAccessTokenExpired()) {
                if ($user->google_refresh_token) {
                    $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                    $user->google_token = $client->getAccessToken();
                    $user->save();
                    $client->setAccessToken($user->google_token);
                }
            }

            $this->addEventToCalendar($pollEvent, $client, $user);


        }
    }

    private function createNewEvent($event, $calendar, $user, $pollEvent){
        $calendarEvent = $calendar->events->insert('primary', $event);
        SyncedEvent::create([
            'calendar_event_id' => $calendarEvent->id,
            'event_id' => $pollEvent->id,
            'user_id' => $user->id,
        ]);
    }


    private function buildEvent($pollEvent)
    {
        $description = $pollEvent->description;
        $description .= "\n\nPoll link: " . route('polls.show', ['poll' => $pollEvent->poll->public_id]);

        return new Event([
            'summary' => 'MeetVote: ' . $pollEvent->title,
            'description' => $description,
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
        // Google Calendar služba
        $calendar = new Calendar($client);

        // Vytvoření události
        $event = $this->buildEvent($pollEvent);


        // Kontrola, zda synchronizovaná událost již existuje
        $calendarEvent = SyncedEvent::where('event_id', $pollEvent->id)
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
}
