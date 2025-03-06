<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class DeletePoll extends Component
{

    public $poll;

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();
    }


    // Smazání ankety
    public function deletePoll()
    {
        $this->poll->delete();
        
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }
        else {
            return redirect()->route('home');
        }

    }

    public function render()
    {
        return view('livewire.modals.delete-poll');
    }
}
