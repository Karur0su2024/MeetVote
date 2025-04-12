<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use App\Traits\HasVoteControls;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Results extends Component
{

    use CanOpenModals;

    public $votes;

    public $poll;

    public $loadedVotes = false;

    public $results = [
        'timeOptions' => [
            'options' => [],
            'selected' => 0,
        ],
        'questions' => [
            'questions' => [],
        ],
    ];



    public function mount($poll, PollResultsService $pollResultsService): void
    {
        $this->poll = $poll;
        $this->poll->load([
            'votes',
            'votes.timeOptions',
            'votes.questionOptions',
            'timeOptions',
            'questions',
            'questions.options',
        ]);

        $this->results = $pollResultsService->getResults($this->poll);
        $this->reloadResults();
    }

    public function reloadResults(): void
    {
        $this->loadedVotes = false;
        $this->poll->load('votes');
        $this->votes = $this->poll->votes;
        $this->loadedVotes = true;
    }

    public function insertToEventModal(EventService $eventService): void
    {
        if(Gate::denies('hasAdminPermissions', $this->poll)){
            $this->openErrorModal();
            return;
        }

        $event = $eventService->buildEventArrayFromValidatedData($this->poll, $this->results);

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
