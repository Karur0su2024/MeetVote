<?php

namespace App\Traits;

use App\Models\Poll;
use App\Services\EventService;
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
            $this->openErrorModal();
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

    public function insertToEventModal(EventService $eventService)
    {

        $event = $eventService->buildEventFromValidatedData($this->poll, $this->results);

        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'eventData' => $event,
                'pollIndex' => $this->poll->id,
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
