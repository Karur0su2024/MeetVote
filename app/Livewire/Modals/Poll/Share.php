<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use Livewire\Component;

class Share extends Component
{
    public $poll;

    public $link;

    public $adminLink;

    public function mount($pollIndex)
    {
        $this->poll = Poll::findOrFail($pollIndex, ['public_id', 'admin_key']);


        $this->link = route('polls.show', ['poll' => $this->poll->public_id]);
        $this->adminLink = route('polls.show.admin', ['poll' => $this->poll->public_id, 'admin_key' => $this->poll->admin_key]);
    }

    public function render()
    {
        return view('livewire.modals.poll.share');
    }
}
