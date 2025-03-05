<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Vote;

class ResultsTable extends Component
{

    public $votes;
    public $poll;

    public function mount($poll)
    {
        $this->poll = $poll;
        $this->votes = $poll->votes;
    }

    public function loadVote($voteIndex)
    {
        $this->dispatch('loadVote', $voteIndex);
    }

    public function deleteVote($voteIndex)
    {
        $vote = Vote::find($voteIndex);
        $vote->delete();
        $this->votes = $this->poll->votes;
    }

    public function render()
    {
        return view('livewire.poll.results-table');
    }
}
