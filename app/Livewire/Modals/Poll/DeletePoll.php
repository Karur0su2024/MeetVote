<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeletePoll extends Component
{
    public $poll;

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();

        if (!$this->poll) {
            session()->flash('error', 'Poll not found.');
            return;
        }
    }

    // Smazání ankety
    public function deletePoll()
    {
        try {
            $this->poll->delete();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the poll.');
            return;
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.modals.poll.delete-poll');
    }
}
