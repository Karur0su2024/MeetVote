<?php

namespace App\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteAccount extends Component
{


    // Metoda pro smazání účtu
    public function deleteAccount()
    {
        // přidat potvrzení
        Auth::user()->delete();

        return redirect()->route('login');
    }


    public function render()
    {
        return view('livewire.user.settings.delete-account');
    }
}
