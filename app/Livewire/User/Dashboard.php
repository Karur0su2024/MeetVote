<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Poll;

class Dashboard extends Component
{
    public $polls;


    public $search = "";

    public function mount()
    {
        $this->loadPolls();


        $this->polls = Auth::user()->polls;
    }

    public function updatingSearch()
    {
        $this->render();
    }

    public function render()
    {
        $this->loadPolls();

        return view('livewire.user.dashboard');
    }


    private function loadPolls()
    {
        $this->polls = Poll::where('user_id', Auth::id())
        ->where('title', 'like', '%' . $this->search . '%')->get();

        
        // Potřebuje opravit
        // Nutné rozdělit podle statusu
        $this->polls = $this->polls->groupBy('status', true);


        //dd($this->polls);
        


    }
}
