<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <div class="container text-center">
        {{-- Livewire komponenta obsahující všechna dostupná nastavení uživatele. --}}
        <livewire:user.settings />
    </div>

</x-layout.app>
