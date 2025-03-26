<?php

namespace App\Traits;

use App\Models\Poll;
use Illuminate\Support\Facades\Gate;

trait CanOpenModals
{

    /**
     * Otevírá všechny modální okna související s anketou.
     *
     * @param string $modalName
     * @param int $pollId
     * @return void
     */
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
            $this->dispatch('showModal', [
                'alias' => 'modals.error',
                'params' => [
                    'errorMessage' => 'You don\'t have permission to access this window. Please check the admin key.'
                ],
            ]);
        }
    }
}
