<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class PollSettings extends Component
{
    public function render()
    {
        return view('livewire.pages.poll-settings')->layout('layouts.app', ['padding' => '5']);
    }
}
