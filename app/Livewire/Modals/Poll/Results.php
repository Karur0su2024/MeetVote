<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\Vote;
use Livewire\Component;

class Results extends Component
{
    public $votes;

    public $poll;

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();
        $this->votes = $this->poll->votes;
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
