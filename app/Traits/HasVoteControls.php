<?php

namespace App\Traits;

use App\Models\Vote;
use Illuminate\Support\Facades\Gate;

trait HasVoteControls
{
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
}
