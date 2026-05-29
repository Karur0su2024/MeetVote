<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component {
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

<form class="flex flex-col gap-3" wire:submit.prevent='deleteAccount'>
    <x-mary-alert title="{{ __('pages/user-settings.delete_account.description') }}"
                  class="alert-error"
                  icon="o-exclamation-triangle"/>
    {{-- Přidat modal pro potvrzení --}}

    <x-mary-input label="{{ __('pages/user-settings.password.labels.old_password') }}"
                  wire:model="current_password"
                  type="password"
                  required/>

    <div>
        <x-mary-button label="{{ __('pages/user-settings.delete_account.buttons.delete_account') }}"
                       class="btn-error"
                       type="submit"
                       spinner/>
    </div>
</form>
