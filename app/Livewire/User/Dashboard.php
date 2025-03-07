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

    // Vyhledávání
    public function updatingSearch()
    {
        $this->render();
    }

    public function render()
    {
        $this->loadPolls();

        return view('livewire.user.dashboard');
    }



    // Načtení anket
    private function loadPolls()
    {

        // Načtení anket
        $this->polls = Poll::where('user_id', Auth::id())
        ->where('title', 'like', '%' . $this->search . '%')->get();

    
        // Seskupení anket podle jejich statusu
        $this->polls = $this->polls->groupBy('status')->all();





    }
}
