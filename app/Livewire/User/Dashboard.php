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

    public $status = 'all';

    public function mount()
    {        //$this->events = Auth::user()->votes()->with('poll')->with('poll.event')->get();

        $this->polls = Auth::user()->polls()->orderBy('created_at', 'desc')->get();

        $this->events = Auth::user()->allPolls()->pluck('event')->unique('id')->filter();
        //dd($this->events);
    }

    public function filterByStatus($status){
        $this->status = $status;
        if ($status === 'all') {
            $this->polls = Auth::user()->polls()->orderBy('created_at', 'desc')->get();
            return;
        }
        $this->polls = Auth::user()->polls()->where('status', $status)->orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.user.dashboard');
    }

    // Načtení anket

}
