<?php

namespace App\Livewire;

use App\Events\PollEventCreated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

class PagePollShowPollSectionEventDetails extends Component
{

    public $event;
    public $poll;
    public $syncGoogleCalendar = false;

    public function mount($poll, $event)
    {
        $this->poll = $poll;
        $this->event = $event;

        if($this->poll && $this->event) {
            $this->event = $this->poll->event()->first();
            if(Auth::check() && $this->event) {
                $this->syncGoogleCalendar = $this->poll->event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty();
            }
        }
    }

    // https://github.com/spatie/calendar-links
    // Import do Google kalendáře
    public function importToGoogleCalendar(): RedirectResponse
    {
        $link = $this->buildLink();
        return redirect()->away($link->google());
    }

    // Import do kalendáře Outlook
    public function importToOutlookCalendar()
    {
        $link = $this->buildLink();
        return redirect()->away($link->webOutlook());
    }

    // Sestavení odkazu pro import do kalendáře
    private function buildLink()
    {
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['start_time']);
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['end_time']);
        return Link::create($this->event['title'], $from, $to)->description($this->event['description']);
    }


    public function createEvent()
    {
        if (Gate::denies('createEvent', $this->poll)) {
            return null;
        }

        $results = $this->pollResultsService->getResults($this->poll);
        $event = $this->eventService->buildEventArrayFromValidatedData($this->poll, $results);
        $this->eventService->createEvent($this->poll, $event);
        PollEventCreated::dispatch($this->poll);
        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_created'));

    }

    public function render()
    {
        return view('livewire.page-poll-show-poll-section-event-details');
    }
}
