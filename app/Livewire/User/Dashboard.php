<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $polls;
    public $search = "";

    public function mount()
    {
        $this->polls = Auth::user()->polls;
    }

    public function updatingSearch()
    {
        $this->render();
    }

    public function render()
    {
        $this->polls = Auth::user()->polls()
            ->where('title', 'like', '%' . $this->search . '%')->get();

        return view('livewire.user.dashboard');
    }
}
