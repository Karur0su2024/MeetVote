<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>User settings</x-slot>

    <div class="container text-center">
        <h1 class="my-3">{{ __('pages.settings.title') }}</h1>

        {{-- Livewire komponenta obsahující všechna dostupná nastavení uživatele. --}}
        <livewire:user.settings />
    </div>

</x-layout.app>
