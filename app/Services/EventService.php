<?php

namespace App\Services;

use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Models\UserEvent;

class EventService
{

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    function synchronizeGoogleCalendar($users, $pollEvent)
    {

        foreach ($users as $user) {
            $client = new Client();
            $client->setApplicationName('MeetVote');
            $client->addScope(Calendar::CALENDAR);
            $client->setClientId(config('services.google.client_id'));
            $client->setClientSecret(config('services.google.client_secret'));
            $client->setAccessToken($user->google_token);

            if ($client->isAccessTokenExpired()) {
                if ($user->google_refresh_token) {
                    $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                    $user->google_token = $client->getAccessToken();
                    $user->save(); // Uložíme nový token do databáze
                    $client->setAccessToken($user->google_token);
                }
            }




            $startDateTime = date('Y-m-d\TH:i:s', strtotime($pollEvent->start_time));
            $endDateTime = date('Y-m-d\TH:i:s', strtotime($pollEvent->end_time));

            // Google Calendar služba
            $calendar = new Calendar($client);

            // Vytvoření události
            $event = new Event([
                'summary' => $pollEvent->title,
                'description' => $pollEvent->description,
                'start' => [
                    'dateTime' => $startDateTime,
                    'timeZone' => 'Europe/Prague',
                ],
                'end' => [
                    'dateTime' => $endDateTime,
                    'timeZone' => 'Europe/Prague',
                ],
            ]);

            $calendarEvent = UserEvent::where('event_id', $pollEvent->id)
                ->where('user_id', $user->id)
                ->first();

            if($calendarEvent){
                try {
                    $calendar->events->get('primary', $calendarEvent->calendar_event_id);
                    $calendar->events->update('primary', $calendarEvent->calendar_event_id, $event);
                }
                catch (\Exception $e) {
                    dd($e->getMessage());
                    $calendarEvent->delete();
                    $this->createNewEvent($event, $calendar, $user, $pollEvent);

                }
            }
            else {
                $this->createNewEvent($event, $calendar, $user, $pollEvent);
            }




        }
    }

    private function createNewEvent($event, $calendar, $user, $pollEvent){
        $calendarEvent = $calendar->events->insert('primary', $event);
        UserEvent::create([
            'calendar_event_id' => $calendarEvent->id,
            'event_id' => $pollEvent->id,
            'user_id' => $user->id,
        ]);
    }
}
