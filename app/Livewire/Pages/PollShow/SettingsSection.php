<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Poll;
use App\Traits\CanOpenModals;
use Livewire\Component;

class SettingsSection extends Component
{
    use CanOpenModals;

    public Poll $poll;

    public function mount($pollIndex): void
    {
        $this->poll = Poll::findOrFail($pollIndex, ['id', 'status', 'public_id', 'admin_key']);
    }


    public function render()
    {
        return view('livewire.pages.poll-show.settings-section');
    }
}
