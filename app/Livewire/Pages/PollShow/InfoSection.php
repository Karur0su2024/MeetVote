<?php

namespace App\Livewire\Pages\PollShow;

use App\Events\PollEventCreated;
use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

class InfoSection extends Component
{
    use CanOpenModals;

    public $poll;
    public $event;
    public $isAdmin = false;

    public $syncGoogleCalendar = false;

    protected PollResultsService $pollResultsService;
    protected EventService $eventService;

    public function boot(PollResultsService $pollResultsService, EventService $eventService): void
    {
        $this->pollResultsService = $pollResultsService;
        $this->eventService = $eventService;
    }


    public function mount($pollIndex): void
    {
        $this->poll = Poll::findOrFail($pollIndex);

        if($this->poll) {
            $this->event = $this->poll->event()->first();
            if(Auth::check() && $this->event) {
                $this->syncGoogleCalendar = $this->poll->event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty();
            }
        }
    }

    public function createEvent()
    {
        if (Gate::denies('createEvent', $this->poll)) {
            return;
        }

        $results = $this->pollResultsService->getResults($this->poll);
        $event = $this->eventService->buildEventFromValidatedData($this->poll, $results);
        $this->eventService->createEvent($this->poll, $event);
        PollEventCreated::dispatch($this->poll);
        return redirect()->route('polls.show', $this->poll)->with('success', 'Event created successfully.');

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
