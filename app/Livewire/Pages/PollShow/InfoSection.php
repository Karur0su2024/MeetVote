<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

class InfoSection extends Component
{
    public $poll;
    public $event;
    public $isAdmin = false;

    public $syncGoogleCalendar = false;

    public function mount($pollIndex): void
    {
        $this->poll = Poll::findOrFail($pollIndex);

        if($this->poll) {
            $this->event = $this->poll->event()->first();
            if(Auth::check() && $this->event) {
                $this->syncGoogleCalendar = $this->poll->event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty();
                //dd($this->syncGoogleCalendar);
            }
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
        return view('livewire.pages.poll-show.info-section');
    }
}
