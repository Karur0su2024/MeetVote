<?php

namespace App\Traits;

use App\Models\Poll;
use App\Services\EventService;
use Illuminate\Support\Facades\Gate;

trait CanOpenModals
{

    public function openModal($modalName, $pollId): void
    {
        $poll = Poll::findOrFail($pollId);

        if(Gate::allows('isAdmin', $poll)) {
            $this->dispatch('showModal', [
                'alias' => $modalName,
                'params' => [
                    'pollIndex' => $pollId,
                ],
            ]);
        }
        else {
            $this->openErrorModal();
        }
    }

    public function openAddNewTimeModal($pollId): void
    {
        $poll = Poll::findOrFail($pollId);
        if(Gate::allows('addNewOption', $poll)) {
            $this->dispatch('showModal', [
                'alias' => 'modals.poll.add-new-time',
                'params' => [
                    'pollIndex' => $poll->id,
                ],
            ]);
        }

    }

    public function openVoteModal($vote): void
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.user-vote',
            'params' => [
                'voteIndex' => $vote['id'],
            ],
        ]);
    }



    public function openErrorModal(): void
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.error',
            'params' => [
                'errorMessage' => 'You don\'t have permission to access this window. Please check the admin key.'
            ],
        ]);
    }
}
