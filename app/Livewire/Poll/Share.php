<?php

namespace App\Livewire\Poll;

use Livewire\Component;

class Share extends Component
{
    public $poll;

    public function render()
    {
        return view('livewire.poll.share');
    }
}
