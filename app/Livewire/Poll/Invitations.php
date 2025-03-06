<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Str;

class Invitations extends Component
{


    public function render()
    {
        return view('livewire.poll.invitations');
    }
}
