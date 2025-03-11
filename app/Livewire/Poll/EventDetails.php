<?php

namespace App\Livewire\Poll;

use DateTime;
use Livewire\Component;
use Spatie\CalendarLinks\Link;
use App\Models\Poll;

class EventDetails extends Component
{

    public $poll;
    public $event;

    public function mount($pollId)
    {
        $this->poll = Poll::find($pollId);

        if($pollId) {
            $this->event = $this->poll->event()->first();
        }
    }


    public function openEventModal($update){

        $event = [
            'poll_id' => $this->poll->public_id,
            'title' => $this->event['title'],
            'all_day' => $this->event['all_day'],
            'start_time' => $this->event['start_time'],
            'end_time' => $this->event['end_time'],
            'description' => $this->event['description'],
        ];


        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'event' => $event,
            ],

        ]);
    }



    // https://github.com/spatie/calendar-links
    public function importToGoogleCalendar()
    {
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['start_time']);
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['end_time']);
        $link = Link::create($this->event['title'], $from, $to)->description($this->event['description']);
        return redirect()->away($link->google());

    }

    public function render()
    {
        return view('livewire.poll.event-details');
    }
}
