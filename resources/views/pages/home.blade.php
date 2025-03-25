<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/homepage.title') }}</x-slot>

    @if(session()->has('warning'))
        <x-ui.alert type="warning">
            {{ session('warning') }}
        </x-ui.alert>
    @endif

    <div class="p-5 card">
        <div class="card-body">
            <h1>{{ __('pages/homepage.headers.welcome') }}</h1>
            <p>
                {{ __('pages/homepage.text.welcome') }}
            </p>
        </div>
    </div>
</x-layouts.app>
