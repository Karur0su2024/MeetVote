<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
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
    public function filterByStatus($status)
    {
        $this->status = $status;
        if ($status === 'all') {
            $this->polls = Auth::user()->polls()->orderBy('created_at', 'desc')->get();

            return;
        }
        $this->polls = Auth::user()->polls()->where('status', $status)->orderBy('created_at', 'desc')->get();
    }
};
