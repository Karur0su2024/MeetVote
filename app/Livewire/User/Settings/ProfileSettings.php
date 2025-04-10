<?php

namespace App\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileSettings extends Component
{

    public $name;

    public $email;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ];
    }

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }


    // Metoda pro aktualizaci jména a emailu
    public function updateProfile()
    {

        $this->validate();

        if (Auth::check()) {
            Auth::user()->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            session()->flash('settings.profile.success', 'Profile updated successfully.');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.profile-settings');
    }
}
