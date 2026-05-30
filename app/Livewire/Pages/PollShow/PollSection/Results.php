<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Deprecated\traits\CanOpenModals;
use App\Services\EventService;
use App\Services\PollResultsService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

// Přehled výsledků ankety
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

    // Vložení výsledků do modálního okna pro vytvoření události
    public function insertToEventModal(EventService $eventService): void
    {
        if (Gate::denies('hasAdminPermissions', $this->poll)) {
            $this->openErrorModal();
            return;
        }

        $event = $eventService->buildEventArrayFromValidatedData($this->poll, $this->results);
        $this->dispatch('openCreateEventModal', [
            'pollId' => $this->poll->id,
            'eventData' => $event,
        ]);

    }

    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.results');
    }
}
