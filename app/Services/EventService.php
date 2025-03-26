<?php

namespace App\Services;

use App\Models\SyncedEvent;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Models\Poll;

class EventService
{

    public function createEvent(Poll $poll, $validatedEventData): string
    {
        $event = $poll->event;

        if($event){
            $poll->event()->update($validatedEventData);
        }
        else{
            $event = $poll->event()->create($validatedEventData);
        }

        return $event;
    }

    public function buildEvent($validatedData): array
    {
        return [
            'poll_id' => $this->poll->public_id,
            'title' => $this->event['title'],
            'all_day' => $this->event['all_day'],
            'start_time' => $this->event['start_time'],
            'end_time' => $this->event['end_time'],
            'description' => $this->event['description'],
        ];
    }

}
