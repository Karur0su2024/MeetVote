<div>

    {{-- Sekce pro nastavení jména a emailové adresy --}}
    <x-card>
        <x-slot:header>Profile Information</x-slot>

        <form wire:submit.prevent='updateProfile'>
            {{-- Přezdívka --}}

            <x-input id="name" model="name" type="text" required>
                Your name
            </x-input>

            {{-- Email --}}
            <x-input id="email" model="email" type="email" required>
                Your email
            </x-input>

            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            {{-- Zpráva v případě úspěšného uložení --}}
            @if (session()->has('settings.profile.success'))
                <span class="text-success ms-3">{{ session('settings.profile.success') }}</span>
            @endif
        </form>
    </x-card>


    {{-- Sekce pro nastavení hesla --}}
    <x-card>
        <x-slot:header>Password</x-slot>

        <form wire:submit.prevent='updatePassword'>
            {{-- Současné heslo --}}
            <x-input id="current_password" model="current_password" type="password" required>
                Current password
            </x-input>

            {{-- Nové heslo --}}
            <x-input id="new_password" model="new_password" type="password" required>
                New password
            </x-input>

            {{-- Potvrzení nového hesla --}}
            <x-input id="password_confirmation" model="new_password_confirmation" type="password" required>
                Confirm new password
            </x-input>

            <button type="submit" class="btn btn-primary">
                Save Changes
            </button>

            {{-- Zpráva v případě úspěšného uložení --}}
            @if (session()->has('settings.password.success'))
                <span class="text-success ms-3">{{ session('settings.password.success') }}</span>
            @endif
        </form>
    </x-card>

    {{-- Sekce pro nastavení  --}}
    <x-card>
        <x-slot:header>Google & Calendar</x-slot>



        @if ($user->google_id)
            <a href="{{ route('google.disconnect') }}" class="btn btn-outline-danger">
                <i class="bi bi-google"></i> Disconnect from Google
            </a>
        @else
            <a href="{{ route('google.login') }}" class="btn btn-outline-primary">
                <i class="bi bi-google"></i> Connect with Google
            </a>
        @endif

        @if (session()->has('settings.google.success'))
            <span class="text-success ms-3">{{ session('settings.google.success') }}</span>
        @endif
        @if (session()->has('settings.google.error'))
            <span class="text-danger ms-3">{{ session('settings.google.error') }}</span>
        @endif
    </x-card>

    <x-card>
        <x-slot:header>Delete account</x-slot>

        {{-- Přidat modal pro potvrzení --}}
        <button class="btn btn-danger" wire:click="deleteAccount">
            Delete account
        </button>
    </x-card>
</div>
