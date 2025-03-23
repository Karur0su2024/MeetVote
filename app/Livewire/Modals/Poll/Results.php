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

    public function boot(VoteService $voteService): void
    {
        $this->voteService = $voteService;
    }

    public function mount($pollIndex)
    {
        $this->poll = Poll::with('votes')->findOrFail($pollIndex, ['id', 'anonymous_votes', 'edit_votes', 'public_id', 'admin_key']);
        $this->votes = $this->voteService->getPollResults($this->poll);
    }

    public function loadVote($voteIndex)
    {
        $this->dispatch('hideModal');
        $this->dispatch('refreshPoll', $voteIndex);
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
