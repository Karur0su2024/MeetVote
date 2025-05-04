<?php

namespace App\Livewire\User\Settings;

use Livewire\Component;

class GoogleSettings extends Component
{
    public $user;

    public function mount(){
        $this->user = auth()->user();
        //dd($this->user);
    }


    public function render()
    {
        return view('livewire.user.settings.google-settings');
    }
}
