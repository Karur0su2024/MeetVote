<?php

namespace App\Services;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class EventService
{

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    function synchronizeGoogleCalendar($users, $event) {

        $path = storage_path('app/calendar.json');

        // Potřeba nastavit pro každého uživatele jiný token, nevím ještě ja
        foreach($users as $user) {
            $client = new Client();
            $client->setApplicationName('MeetVote');
            $client->addScope(Calendar::CALENDAR);
            $client->setAccessToken($path);
            $calendar = new Calendar($client);


            $event = new Event([
                'summary' => $event['title'],
                'description' => $event['description'],
                'start' => [
                    'dateTime' => $event['start_time'],
                    'timeZone' => 'Europe/Prague',
                ],
                'end' => [
                    'dateTime' => $event['end_time'],
                    'timeZone' => 'Europe/Prague',
                ],
            ]);

            $calendar->events->insert('primary', $event);


        }

    }

}
