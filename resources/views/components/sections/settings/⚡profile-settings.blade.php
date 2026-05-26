<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
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
};
?>

<div>
    <form wire:submit.prevent='updateProfile'>
        {{-- Přezdívka --}}
        <x-ui.form.tw-input
            id="name"
            wire:model="name"
            type="text"
            required>
            <x-slot:label>
                {{ __('pages/user-settings.profile_settings.labels.name') }}
            </x-slot:label>
        </x-ui.form.tw-input>

        <x-ui.form.tw-input
            id="name"
            wire:model="email"
            type="text"
            required>
            <x-slot:label>
                {{ __('pages/user-settings.profile_settings.labels.email') }}
            </x-slot:label>
        </x-ui.form.tw-input>

        <x-ui.tw-button type="submit" color="primary">
            {{ __('pages/user-settings.profile_settings.buttons.save') }}
        </x-ui.tw-button>

        {{-- Zpráva v případě úspěšného uložení --}}
        @if (session()->has('settings.profile.success'))
            <span class="tw:text-success tw:ms-3">{{ session('settings.profile.success') }}</span>
        @endif
    </form>

</div>
