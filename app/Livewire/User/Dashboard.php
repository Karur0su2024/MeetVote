<?php

namespace App\Livewire\User;

use App\Models\Poll;
use App\Traits\Traits\CanOpenModals;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    use CanOpenModals;

    public $polls;

    public $events;

    public $search = '';

    public function mount()
    {
        $this->loadPolls();
        //$this->events = Auth::user()->votes()->with('poll')->with('poll.event')->get();

        $this->polls = Poll::where('user_id', Auth::id())
            ->where('title', 'like', '%'.$this->search.'%')->get();

        $this->events = Auth::user()->allPolls()->pluck('event')->unique('id')->filter();
        //dd($this->events);
    }

    // Vyhledávání
    public function updatingSearch()
    {

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
            ->where('title', 'like', '%'.$this->search.'%')->get();

    }

}
