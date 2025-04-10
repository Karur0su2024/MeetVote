{{-- Sekce pro nastavení hesla --}}
<x-ui.card>
    <x-slot:header>{{ __('pages/user-settings.password.title') }}</x-slot>

    <form wire:submit.prevent='updatePassword'>
        {{-- Současné heslo --}}
        <x-ui.form.input id="current_password"
                         wire:model="current_password"
                         type="password"
                         required>
            {{ __('pages/user-settings.password.labels.old_password') }}
        </x-ui.form.input>

        {{-- Nové heslo --}}
        <x-ui.form.input id="new_password"
                         wire:model="new_password"
                         type="password"
                         required>
            {{ __('pages/user-settings.password.labels.new_password') }}
        </x-ui.form.input>

        {{-- Potvrzení nového hesla --}}
        <x-ui.form.input id="password_confirmation"
                         wire:model="new_password_confirmation"
                         type="password"
                         required>
            {{ __('pages/user-settings.password.labels.new_password_confirmation') }}
        </x-ui.form.input>

        <x-ui.button type="submit">
            {{ __('pages/user-settings.password.buttons.save') }}
        </x-ui.button>

        {{-- Zpráva v případě úspěšného uložení --}}
        @if (session()->has('settings.password.success'))
            <span class="text-success ms-3">{{ session('settings.password.success') }}</span>
        @endif
    </form>
</x-ui.card>
