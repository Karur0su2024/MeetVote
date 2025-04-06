<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Results extends Component
{

    public $votes;
    public $poll;

    public $loadedVotes = false;


    public $results = [];

    public function mount($poll, PollResultsService $pollResultsService){
        $this->poll = $poll;
        $this->results = $pollResultsService->getResults($poll);
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


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.results');
    }
}
