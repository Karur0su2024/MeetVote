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
            return __('ui/modals.create_event.messages.success.event_updated');
        }
        else{
            $event = $poll->event()->create($validatedEventData);
            return __('ui/modals.create_event.messages.success.event_created');
        }

    }

}
