<?php

namespace App\Deprecated\livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public $current_password;

    public function rules(): array
    {
        return [
            'current_password' => 'required',
        ];
    }

    // Metoda pro smazání účtu
    public function deleteAccount()
    {

        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $this->validate();

        // přidat potvrzení
        Auth::user()->delete();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.user.settings.delete-account');
    }
}
