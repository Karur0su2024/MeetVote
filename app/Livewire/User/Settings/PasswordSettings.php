<?php

namespace App\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PasswordSettings extends Component
{


    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ];
    }


    // Metoda pro aktualizaci hesla
    public function updatePassword()
    {
        
        // Zjištění, zda je aktuální heslo správné
        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        // Validace nového hesla
        $this->validate();

        // Aktualizace hesla
        Auth::user()->update([
            'password' => bcrypt($this->new_password),
        ]);

        $this->reset();

        session()->flash('settings.password.success', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.user.settings.password-settings');
    }
}
