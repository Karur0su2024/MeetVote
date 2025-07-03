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
class InfoSection extends Component
{
    use CanOpenModals;
    use HasVoteControls;

    public $poll;
    public $event;
    public $userVote;

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
        }
    }






    public function render()
    {
        return view('livewire.pages.poll-show.info-section');
    }
}
