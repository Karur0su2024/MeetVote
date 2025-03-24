<?php

namespace App\Traits\Traits;

use App\Models\Poll;
use Illuminate\Support\Facades\Gate;

trait CanOpenModals
{
    public function openModal($modalName, $pollId)
    {
        $poll = Poll::findOrFail($pollId);

        if(Gate::allows('isAdmin', $poll)) {
            $this->dispatch('showModal', [
                'alias' => $modalName,
                'params' => [
                    'pollId' => $pollId,
                ],
            ]);
        }
        else {
            $this->dispatch('showModal', [
                'alias' => 'modals.error',
                'params' => [
                    'errorMessage' => 'You don\'t have permission to access this window. Please check the admin key.'
                ],
            ]);
        }
    }
}
