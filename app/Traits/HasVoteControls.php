<?php

namespace App\Traits;

use App\Models\Vote;
use Illuminate\Support\Facades\Gate;

trait HasVoteControls
{
    // Načtení existujícího odpovědi
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


    // Odstranění odpovědi
    public function deleteVote($voteIndex)
    {
        $vote = Vote::where('id', $voteIndex)->firstOrFail();

        if(Gate::allows('delete', $vote)) {
            $vote->delete();
            return redirect(request()->header('Referer'))->with('success', __('pages/poll-show.messages.success.vote_deleted'));
        }

        $this->addError('error', __('ui.modals.results.messages.error.delete'));

    }
}
