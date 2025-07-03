{{-- Sekce pro nastavení jména a emailové adresy --}}
<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/user-settings.profile_settings.title') }}
    </x-slot:title>

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
            <span class="text-success ms-3">{{ session('settings.profile.success') }}</span>
        @endif
    </form>
</x-ui.tw-card>
