<?php

use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

new class extends Component
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
};
?>

{{--

IDEA: Přidat nějaký hezčí souhrn výsledků
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div class="flex flex-col gap-1">
    <div class="card bg-base-100 poll-section-card p-3">
        <h5 class="text-lg font-medium mb-2">{{ __('pages/poll-show.results.sections.all_votes.title') }}</h5>
        <div class="flex gap-2">
            @forelse($votes as $vote)
                <button class="btn btn-sm btn-dash btn-outline"
                        @click="$wire.dispatch('openUserVoteModal', { voteId: {{ $vote->id }} })">
                    {{ ($poll->settings['anonymous_votes'] ?? false) ? __('pages/poll-show.results.sections.all_votes.anonymous') : (Auth::user()->name ?? $vote->voter_name) }}
                </button>
            @empty
                {{ __('pages/poll-show.results.sections.all_votes.empty') }}
            @endforelse

        </div>
    </div>



    @can('viewResults', $poll)

        @can('chooseResults', $poll)
            <x-pages.poll-show.poll.results.pick-results-form :results="$results"/>
        @else
            <x-pages.poll-show.poll.results.view-only :results="$results"/>
        @endcan

    @else
        <x-mary-alert title="{{ __('pages/poll-show.results.alerts.hidden') }}"
                      class="alert-info alert-soft"
                      icon="o-information-circle"/>
    @endcan

</div>
