<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Settings extends Component
{
    public $user;

    public $name;

    public $email;

    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public $flashMessages = [
        'settings.profile.success',
        'settings.password.success',
    ];

    public function mount()
    {


        $this->user = Auth::user();

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    // Metoda pro aktualizaci jména a emailu
    public function updateProfile()
    {
        // Validace jména a emailu
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ]);

        // Zjištění, zda je uživatel přihlášený
        // Aktualizace jména a emailu
        if (Auth::check()) {
            Auth::user()->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            session()->flash('settings.profile.success', 'Profile updated successfully.');
        }
    }

    // Metoda pro aktualizaci hesla
    public function updatePassword()
    {

        // Zjištění, zda je aktuální heslo správné
        if (! Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('password', 'Current password is incorrect.');
        }

        // Validace nového hesla
        $this->validate([
            'new_password' => 'required|string|min:8|confirmed|different:current_password',
        ]);

        // Aktualizace hesla
        Auth::user()->update([
            'password' => bcrypt($this->new_password),
        ]);

        // Resetování proměnných
        // Přesunout do vlastní metody
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('settings.password.success', 'Password updated successfully.');
    }

    // Metoda pro smazání účtu
    public function deleteAccount()
    {
        // přidat potvrzení
        Auth::user()->delete();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.user.settings');
    }
}
