<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\Vote;
use App\Services\Vote\VoteService;
use App\Traits\HasVoteControls;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;


class UserVote extends Component
{
    use HasVoteControls;

    public $vote;

    public function mount($voteIndex)
    {
        $this->vote = Vote::where('id', $voteIndex)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.modals.poll.user-vote');
    }
}
