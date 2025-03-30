<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\Vote;
use App\Services\Vote\VoteService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;


class Results extends Component
{
    public $votes;
    public $poll;

    public $loadedVotes = false;

    public function mount($pollIndex)
    {
        $this->poll = Poll::findOrFail($pollIndex, ['id', 'anonymous_votes', 'edit_votes', 'public_id', 'admin_key']);
        $this->reloadResults();
    }

    public function loadVote($voteIndex)
    {
        $vote = Vote::where('id', $voteIndex)->firstOrFail();

        if(Gate::allows('edit', $vote)) {
            $this->dispatch('hideModal');
            $this->dispatch('refreshPoll', $voteIndex);
            return;
        }
        $this->addError('error', __('ui.modals.results.messages.error.load'));
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
        $vote = Vote::where('id', $voteIndex)->firstOrFail();

        if(Gate::allows('delete', $vote)) {
            $vote->delete();
            $this->reloadResults();
            return;
        }

        $this->addError('error', __('ui.modals.results.messages.error.delete'));

    }

    public function render()
    {
        return view('livewire.modals.poll.results');
    }
}
