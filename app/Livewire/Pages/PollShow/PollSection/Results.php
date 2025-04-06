<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Results extends Component
{

    public $votes;
    public $poll;

    public $loadedVotes = false;

    public $results = [
        'timeOptions' => [
            'options' => [],
            'selected' => 0,
        ],
        'questions' => [
            'questions' => [
            ],
        ],
    ];



    public function mount($poll, PollResultsService $pollResultsService){
        $this->poll = $poll;
        $this->poll->load([
            'timeOptions',
            'questions',
            'questions.options',
        ]);

        $this->results = $pollResultsService->getResults($this->poll);
        $this->reloadResults();
    }

    public function reloadResults()
    {
        $this->loadedVotes = false;
        $this->poll->load('votes');
        $this->votes = $this->poll->votes;
        $this->loadedVotes = true;
    }


    public function openVoteModal($vote): void
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.results',
            'params' => [
                'voteIndex' => $vote['id'],
            ],
        ]);
    }

    public function insertToEventModal(EventService $eventService)
    {

        $event = $eventService->buildEventFromValidatedData($this->poll, $this->results);

        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'eventData' => $event,
                'pollIndex' => $this->poll->id,
            ],

        ]);

    }


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.results');
    }
}
