<?php

namespace App\Services\Google;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event as GoogleEvent;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected Calendar $calendar;

    public function __construct(Client $client)
    {
        $this->calendar = new Calendar($client); // Inicializace Google Kalendáře
    }

    //https://ggomez.dev/blog/how-to-integrate-google-calendar-with-laravel
    // Metoda pro synchronizaci události s Google Kalendářem
    public function syncEvent($googleEvent, $event, $user)
    {
        $this->desyncEvent($event, $user->id);

        try{
            $calendarEvent = $this->calendar->events->insert('primary', $googleEvent);
            $event->syncedEvents()->create([
                'calendar_event_id' => $calendarEvent->id, // ID události v Google Kalendáři
                'user_id' => $user->id,
            ]);
        }
        catch (\Exception $e){
            Log::error('Error while syncing event :' . $e->getMessage());
        }


    }

    public function desyncEvent(Event $event, $userIndex)
    {
        $syncEvent = $event->syncedEvents()->where('user_id', $userIndex)->first();
        if($syncEvent) {
            try {
                $this->calendar->events->get('primary', $syncEvent->calendar_event_id); // Získání události z Google Kalendáře
                $this->calendar->events->delete('primary', $syncEvent->calendar_event_id); // Smazání události z Google Kalendáře
            } catch (\Exception $e) {
                Log::error('Error while desyncing event');
            }

            $syncEvent->delete();
        }

    }

    public function buildGoogleEvent($event)
    {
        $description = $event->description;
        $timezone = $event->poll->timezone;
        $description .= "\n\nPoll link: " . route('polls.show', ['poll' => $event->poll->public_id]); // Odkaz na anketu

        return new GoogleEvent([
            'summary' => 'MeetVote: ' . $event->title,
            'description' => $description,
            'start' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($event->start_time)),
                'timeZone' => $timezone,
            ],
            'end' => [
                'dateTime' => date('Y-m-d\TH:i:s', strtotime($event->end_time)),
                'timeZone' => $timezone,
            ],
        ]);

    }


    public function getCalendarEvents($option)
    {
        $calendarList = $this->calendar->calendarList->listCalendarList();
        $calendars = $calendarList->getItems();
        $calendarsEvents = [];

        foreach ($calendars as $calendar) {
            $calendarId = $calendar->id;
            $eventDetails = [
                'timeMin' => $this->getCalendarDateTimeFormat($option['date'], $option['content']['start'] ?? '0:00'),
                'timeMax' => $this->getCalendarDateTimeFormat($option['date'], $option['content']['end'] ?? '0:00'),
                'timeZone' => date_default_timezone_get(),
            ];
            $events = $this->calendar->events->listEvents($calendarId, $eventDetails);

            $calendarsEvents[$calendarId] = $this->calendar->events->listEvents($calendarId, $eventDetails)->getItems();
        }


        return array_merge(...array_values($calendarsEvents));
    }


    private function getCalendarDateTimeFormat($date, $time): string
    {
        $datetime = $date . ' ' . $time;
        return date('c', strtotime($datetime));
    }


}
