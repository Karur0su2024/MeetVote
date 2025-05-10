<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

// Modální okno pro sdílení ankety
class Share extends Component
{
    public $poll;

    public $link;

    public $adminLink;

    public function mount($pollIndex)
    {
        $this->poll = Poll::findOrFail($pollIndex, ['id', 'user_id', 'public_id', 'admin_key']);

        if (Gate::allows('isAdmin', $this->poll)){
            $this->link = route('polls.show', ['poll' => $this->poll->public_id]);
            $this->adminLink = route('polls.show.admin', ['poll' => $this->poll->public_id, 'admin_key' => $this->poll->admin_key]);
        }
        else {
            $this->link = '[REDACTED]';
            $this->adminLink = '[REDACTED]';
        }

    }

    public function render()
    {
        return view('livewire.modals.poll.share');
    }
}
