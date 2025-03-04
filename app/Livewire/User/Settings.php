<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{

    public $name;
    public $email;
    public $current_password;
    public $new_password;
    public $confirm_password;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }


    // Metoda pro aktualizaci jména a emailu
    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

    }


    public function render()
    {
        return view('livewire.user.settings');
    }
}
