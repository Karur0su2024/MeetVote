<?php

namespace App\Livewire\Pages\PollShow;


use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\HasVoteControls;
use Livewire\Component;

// Sekce s detaily o anketě
class InfoSection extends Component
{
    use HasVoteControls;

    public $poll;

    public $event;

    protected PollResultsService $pollResultsService;

    protected EventService $eventService;

    public $status;

    public $hasEvent;

    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);

        if ($this->poll) {
            $this->event = $this->poll->event()->first();
        }

        $this->hasEvent = $this->poll->event()->exists();

    }


    public function render()
    {
        return view('livewire.pages.poll-show.info-section');
    }

}
