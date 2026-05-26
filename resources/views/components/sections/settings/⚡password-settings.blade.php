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

<form wire:submit.prevent='updatePassword'>
    {{-- Současné heslo --}}
    <x-ui.form.tw-input id="current_password"
                        wire:model="current_password"
                        type="password"
                        required>
        <x-slot:label>
            {{ __('pages/user-settings.password.labels.old_password') }}
        </x-slot:label>
    </x-ui.form.tw-input>

    {{-- Nové heslo --}}
    <x-ui.form.tw-input id="new_password"
                        wire:model="new_password"
                        type="password"
                        required>
        <x-slot:label>
            {{ __('pages/user-settings.password.labels.new_password') }}
        </x-slot:label>
    </x-ui.form.tw-input>

    {{-- Potvrzení nového hesla --}}
    <x-ui.form.tw-input id="password_confirmation"
                        wire:model="new_password_confirmation"
                        type="password"
                        required>
        <x-slot:label>
            {{ __('pages/user-settings.password.labels.new_password_confirmation') }}
        </x-slot:label>
    </x-ui.form.tw-input>

    <x-ui.tw-button type="submit">
        {{ __('pages/user-settings.password.buttons.save') }}
    </x-ui.tw-button>

    {{-- Zpráva v případě úspěšného uložení --}}
    @if (session()->has('settings.password.success'))
        <span class="text-success ms-3">{{ session('settings.password.success') }}</span>
    @endif
</form>


