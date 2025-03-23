<?php

namespace App\Livewire\Pages\PollShow;

use Livewire\Component;
use App\Models\Poll;
use Illuminate\Support\Facades\Gate;

class SettingsSection extends Component
{

    public Poll $poll;

    public function mount($pollId): void
    {
        $this->poll = Poll::findOrFail($pollId, ['id', 'status', 'public_id', 'admin_key']);
    }

    public function openModal($modalName, $pollId)
    {
        if(Gate::allows('isAdmin', $this->poll)) {
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

    public function render()
    {
        return view('livewire.pages.poll-show.settings-section');
    }
}
