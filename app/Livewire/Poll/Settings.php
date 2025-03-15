<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Poll;

class Settings extends Component
{


    public Poll $poll;

    public function mount(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function render()
    {
        return view('livewire.poll.settings');
    }


    public function openModal($modalName, $publicId)
    {
        if (session()->has('poll_' . $publicId . '_adminKey')) {
            $poll = Poll::where('public_id', $publicId)->first();
            if (!$poll) {
                $this->dispatch('showModal', [
                    'alias' => 'modals.error',
                    'params' => [
                        'errorMessage' => 'You don\'t have permission to access this window. Please check the admin key.'
                    ],
                ]);
                return;
            }
            if (session()->get('poll_' . $publicId . '_adminKey') === $poll->admin_key) {
                $this->dispatch('showModal', [
                    'alias' => $modalName,
                    'params' => [
                        'publicIndex' => $publicId,
                    ],
                ]);
                return;
            }
        }
        $this->dispatch('showModal', [
            'alias' => 'modals.error',
            'params' => [
                'errorMessage' => 'You don\'t have permission to access this window. Please check the admin key.'
            ],
        ]);
    }
}
