<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Poll;
use App\Traits\CanOpenModals;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

class InfoSection extends Component
{
    use CanOpenModals;

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



    public function openEventModal(){
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'pollIndex' => $this->poll,
                'eventIndex' => $this->event,
            ],

        ]);
    }

    // https://github.com/spatie/calendar-links
    public function importToGoogleCalendar()
    {
        $link = $this->buildLink();
        return redirect()->away($link->google());
    }

    public function importToOutlookCalendar()
    {
        $link = $this->buildLink();
        return redirect()->away($link->webOutlook());
    }


    private function buildLink()
    {
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['start_time']);
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['end_time']);
        return Link::create($this->event['title'], $from, $to)->description($this->event['description']);
    }


    public function render()
    {
        return view('livewire.pages.poll-show.info-section');
    }
}
