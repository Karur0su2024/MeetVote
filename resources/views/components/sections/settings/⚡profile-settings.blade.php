<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public $name;

    public $email;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
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

<form class="flex flex-col gap-3" wire:submit.prevent='updateProfile'>
    {{-- Přezdívka --}}
    <x-mary-input label="{{ __('pages/user-settings.profile_settings.labels.name') }}"
                  wire:model="name"
                  required/>

    <x-mary-input label="{{ __('pages/user-settings.profile_settings.labels.email') }}"
                  type="email"
                  wire:model="email"
                  required/>


    <div>
        <x-mary-button label="{{ __('pages/user-settings.profile_settings.buttons.save') }}"
                       class="btn-primary"
                       type="submit"
                       spinner/>
    </div>

    {{-- Zpráva v případě úspěšného uložení --}}
    @if (session()->has('settings.profile.success'))
        <span class="tw:text-success tw:ms-3">{{ session('settings.profile.success') }}</span>
    @endif
</form>

