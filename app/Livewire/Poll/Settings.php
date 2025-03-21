<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Poll;

class Settings extends Component
{

    public Poll $poll;

    public function mount(int $pollId)
    {
        // Notifikace přidat dodatečně
        $this->poll = Poll::findOrFail($pollId, ['id', 'status', 'public_id', 'admin_key']);
    }

    public function openModal($modalName, $publicId)
    {
        $poll = Poll::exists($this->poll->id);
        if (!$poll) {
            return abort(404);
        }


        $this->dispatch('showModal', [
            'alias' => $modalName,
            'params' => [
                'publicIndex' => $this->poll->public_id,
            ],
        ]);

        // Tohle opravit později
        return ;

        if (session()->has('poll_' . $this->poll->public_id . '_adminKey')) {
            if (session()->get('poll_' . $this->poll->public_id . '_adminKey') === $this->poll->admin_key) {
                $this->dispatch('showModal', [
                    'alias' => $modalName,
                    'params' => [
                        'publicIndex' => $this->poll->public_id,
                    ],
                ]);
                return null;
            }
            else {
                $this->openErrorModal('You don\'t have permission to access this window. Please check the admin key.');
            }
        } else {
            $this->openErrorModal('You don\'t have permission to access this window. Please check the admin key.');
        }
    }

    private function openErrorModal($errorMessage)
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.error',
            'params' => [
                'errorMessage' => $errorMessage
            ],
        ]);
    }


    public function render()
    {
        return view('livewire.poll.settings');
    }
}
