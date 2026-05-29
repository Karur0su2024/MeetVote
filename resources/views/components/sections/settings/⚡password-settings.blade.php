<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component
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

    public function updatePassword()
    {

        // Kontrola aktualního hesla
        if (! Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Current password is incorrect.');

            return;
        }

        $this->validate();

        // Aktualizace hesla
        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Resetování hodnot
        $this->reset();

        session()->flash('settings.password.success', 'Password updated successfully.');
    }
};
?>

<form class="flex flex-col gap-3" wire:submit.prevent='updatePassword'>
    {{-- Současné heslo --}}
    <x-mary-input label="{{ __('pages/user-settings.password.labels.old_password') }}"
                  wire:model="current_password"
                  type="password"
                  required />

    {{-- Nové heslo --}}
    <x-mary-input label="{{ __('pages/user-settings.password.labels.new_password') }}"
                  wire:model="new_password"
                  type="password"
                  required />

    {{-- Potvrzení nového hesla --}}
    <x-mary-input label="{{ __('pages/user-settings.password.labels.new_password_confirmation') }}"
                  wire:model="new_password_confirmation"
                  type="password"
                  required />

    <div>
        <x-mary-button label="{{ __('pages/user-settings.password.buttons.save') }}"
                       class="btn-primary"
                       type="submit"
                       spinner />
    </div>



    {{-- Zpráva v případě úspěšného uložení --}}
    @if (session()->has('settings.password.success'))
        <span class="text-success ms-3">{{ session('settings.password.success') }}</span>
    @endif
</form>


