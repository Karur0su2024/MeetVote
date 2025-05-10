{{-- Sekce na stránce nastavení pro připojení Google účtu a Kalendáře --}}
<x-ui.card header-hidden>
    <x-slot:body-header>
        <h2 class="mb-3">
            {{ __('pages/user-settings.google.title') }}
        </h2>

    </x-slot:body-header>
    <x-slot:body>

        @if ($user->google_id)
            <p class="text-muted">
                {{ __('pages/user-settings.google.connected.text') }}
            </p>

            <a href="{{ route('google.oauth.disconnect') }}" class="btn btn-outline-danger">
                <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.disconnect') }}
            </a>

            @if($user->calendar_access)
                <p class="text-muted">
                    {{ __('pages/user-settings.google.text.synced_events', ['synced_events_count' => $user->syncedEvents->count()]) }}
                </p>
                <a href="{{ route('google.calendar.disconnect') }}" class="btn btn-outline-danger">
                    <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.disconnect_calendar') }}
                </a>
            @else
                <a href="{{ route('google.calendar.login') }}" class="btn btn-outline-primary">
                    <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.connect_calendar') }}
                </a>

            @endif

        @else
            <a href="{{ route('google.oath.login') }}" class="btn btn-outline-primary">
                <i class="bi bi-google"></i> {{ __('pages/user-settings.google.buttons.connect') }}
            </a>
        @endif

        @if (session()->has('settings.google.success'))
            <span class="text-success ms-3">{{ session('settings.google.success') }}</span>
        @endif
        @if (session()->has('settings.google.error'))
            <span class="text-danger ms-3">{{ session('settings.google.error') }}</span>
        @endif
    </x-slot:body>
</x-ui.card>
