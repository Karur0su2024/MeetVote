<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

// Modální okno pro smazání ankety
class DeletePoll extends Component
{
    public $poll;

    public function mount($pollIndex)
    {
        $this->poll = Poll::find($pollIndex, ['id', 'user_id']);
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
