{{-- Sekce pro nastavení hesla --}}
<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/user-settings.password.title') }}
    </x-slot:title>

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

</x-ui.tw-card>
