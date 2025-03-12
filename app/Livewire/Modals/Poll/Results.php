<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\Vote;
use Livewire\Component;
use App\Services\VoteService;

class Results extends Component
{
    public $votes;

    public $poll;


    protected VoteService $voteService;

    public function __construct()
    {
        $this->voteService = app(VoteService::class);
    }

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();

        //Převézt do pole pro lepší vypsání
        $this->votes = $this->voteService->getPollResults($this->poll);
    }

    public function loadVote($voteIndex)
    {
        $this->dispatch('hideModal');
        $this->dispatch('loadVote', $voteIndex);
    }

    public function deleteVote($voteIndex)
    {
        $vote = Vote::find($voteIndex);
        $vote->delete();
        $this->votes = $this->poll->votes;

        $this->dispatch('updateOptions');
        $this->dispatch('removeVote');
    }

    public function render()
    {
        return view('livewire.modals.poll.results');
    }
}
