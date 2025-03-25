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

    public $loadedVotes = false;

    protected VoteService $voteService;

    public function boot(VoteService $voteService): void
    {
        $this->voteService = $voteService;
    }

    public function mount($pollIndex)
    {
        $this->poll = Poll::findOrFail($pollIndex, ['id', 'anonymous_votes', 'edit_votes', 'public_id', 'admin_key']);
        $this->reloadResults();
    }

    public function loadVote($voteIndex)
    {
        $this->dispatch('hideModal');
        $this->dispatch('refreshPoll', $voteIndex);
    }

    public function reloadResults()
    {
        $this->loadedVotes = false;
        $this->poll->load('votes');
        $this->votes = $this->poll->votes;
        $this->loadedVotes = true;
    }

    public function deleteVote($voteIndex)
    {
        $vote = Vote::find($voteIndex);
        $vote->delete();
        $this->reloadResults();

        $this->dispatch('updateOptions');
        $this->dispatch('removeVote');
    }

    public function render()
    {
        return view('livewire.modals.poll.results');
    }
}
