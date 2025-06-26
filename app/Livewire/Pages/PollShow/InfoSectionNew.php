<?php

namespace App\Livewire\Pages\PollShow;

use App\Events\PollEventCreated;
use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use App\Traits\HasVoteControls;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

// Sekce s detaily o anketě
class InfoSectionNew extends Component
{
    use CanOpenModals;
    use HasVoteControls;

    public $poll;
    public $event;
    public $userVote;

    public $syncGoogleCalendar = false;

    protected PollResultsService $pollResultsService;
    protected EventService $eventService;

    public function boot(PollResultsService $pollResultsService, EventService $eventService): void
    {
        $this->pollResultsService = $pollResultsService;
        $this->eventService = $eventService;
    }


    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->userVote = $pollResultsService->getUserVote($this->poll);


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
            return null;
        }

        $results = $this->pollResultsService->getResults($this->poll);
        $event = $this->eventService->buildEventArrayFromValidatedData($this->poll, $results);
        $this->eventService->createEvent($this->poll, $event);
        PollEventCreated::dispatch($this->poll);
        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_created'));

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


    public function render()
    {
        return view('livewire.pages.poll-show.info-section-new');
    }
}
