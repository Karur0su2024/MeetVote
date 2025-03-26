<div>

    {{-- Sekce pro nastavení jména a emailové adresy --}}
    <x-ui.card>
        <x-slot:header>{{ __('pages/user-settings.profile_settings.title') }}</x-slot>

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
    </x-ui.card>


    {{-- Sekce pro nastavení hesla --}}
    <x-ui.card>
        <x-slot:header>{{ __('pages/user-settings.password.title') }}</x-slot>

        <form wire:submit.prevent='updatePassword'>
            {{-- Současné heslo --}}
            <x-ui.form.input id="current_password"
                             wire:modelmodel="current_password"
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

    {{-- Sekce pro nastavení  --}}
    <x-ui.card>
        <x-slot:header>{{ __('pages/user-settings.google.title') }}r</x-slot>



        @if ($user->google_id)
            <a href="{{ route('google.disconnect') }}" class="btn btn-outline-danger">
                <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.disconnect') }}
            </a>
        @else
            <a href="{{ route('google.login') }}" class="btn btn-outline-primary">
                <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.connect') }}
            </a>
        @endif

        @if (session()->has('settings.google.success'))
            <span class="text-success ms-3">{{ session('settings.google.success') }}</span>
        @endif
        @if (session()->has('settings.google.error'))
            <span class="text-danger ms-3">{{ session('settings.google.error') }}</span>
        @endif
    </x-ui.card>

    <x-ui.card>
        <x-slot:header>{{ __('pages/user-settings.delete_account.title') }}</x-slot>
        <p class="text-muted">
            {{ __('pages/user-settings.delete_account.description') }}
        </p>
        {{-- Přidat modal pro potvrzení --}}
        <x-ui.button color="danger"
                     wire:click="deleteAccount">
            {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
        </x-ui.button>
    </x-ui.card>
</div>
