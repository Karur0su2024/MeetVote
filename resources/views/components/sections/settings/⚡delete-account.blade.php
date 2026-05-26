<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component
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
};
?>

<form wire:submit.prevent='deleteAccount'>
    <p class="opacity-50">

    </p>

    <x-mary-alert title="{{ __('pages/user-settings.delete_account.description') }}"
                  class="alert-error"
                  icon="o-exclamation-triangle" />
    {{-- Přidat modal pro potvrzení --}}

    <x-ui.form.tw-input id="current_password"
                        wire:model="current_password"
                        type="password"
                        required>
        <x-slot:label>
            {{ __('pages/user-settings.password.labels.old_password') }}
        </x-slot:label>
    </x-ui.form.tw-input>
    <button class="btn btn-error max-w-xs">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </button>
</form>
