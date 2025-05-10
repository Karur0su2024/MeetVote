<?php

namespace App\Livewire\User;

use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    use CanOpenModals;

    public $polls;

    public $votes;

    public $events;

    public $status = 'all';

    public function mount()
    {

        $this->polls = Auth::user()->polls()->orderBy('created_at', 'desc')->get();

        $this->events = Auth::user()->allPolls()->pluck('event')->unique('id')->filter();

        $this->votes = Auth::user()->votes()->with('poll')->orderBy('created_at', 'desc')->limit(3)->get();
    }

    // Načtení anket podle jejich stavu
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


}
