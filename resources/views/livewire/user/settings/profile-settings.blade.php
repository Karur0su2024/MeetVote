{{-- Sekce pro nastavení jména a emailové adresy --}}
<x-ui.card header-hidden>
    <x-slot:body-header>
        <h2 class="mb-3">
            {{ __('pages/user-settings.profile_settings.title') }}
        </h2>

    </x-slot:body-header>
    <x-slot:body>


        <form wire:submit.prevent='updateProfile'>
            {{-- Přezdívka --}}

            <x-ui.form.input
                id="name"
                wire:model="name"
                type="text"
                required>
                {{ __('pages/user-settings.profile_settings.labels.name') }}
            </x-ui.form.input>

            {{-- Email --}}
            <x-ui.form.input
                id="email"
                wire:model="email"
                type="email"
                required>
                {{ __('pages/user-settings.profile_settings.labels.email') }}
            </x-ui.form.input>

            <x-ui.button type="submit">
                {{ __('pages/user-settings.profile_settings.buttons.save') }}
            </x-ui.button>

            {{-- Zpráva v případě úspěšného uložení --}}
            @if (session()->has('settings.profile.success'))
                <span class="text-success ms-3">{{ session('settings.profile.success') }}</span>
            @endif
        </form>
    </x-slot:body>
</x-ui.card>
