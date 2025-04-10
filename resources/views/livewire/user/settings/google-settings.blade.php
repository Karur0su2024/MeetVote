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
