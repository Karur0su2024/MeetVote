<?php

namespace App\Livewire\Modals\Poll;

use Livewire\Component;
use App\Models\Poll;

class Share extends Component
{
    public $poll;
    public $link;
    public $adminLink;

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();
        $this->link = route('polls.show', ['poll' => $this->poll->public_id]);
        $this->adminLink = route('polls.show.admin', ['poll' => $this->poll->public_id, 'admin_key' => $this->poll->admin_key]);
    }

    public function render()
    {
        return view('livewire.modals.share');
    }
}
