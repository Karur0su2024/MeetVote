<x-dropdown id="languageDropdown" class="nav-item">
    <x-slot:header>
        <i class="bi bi-globe me-1"></i> {{ __('navbar.language') }}
    </x-slot:header>
    <x-dropdown-item href="{{ route('changeLanguage', 'en') }}">
        English
    </x-dropdown-item>
    <x-dropdown-item href="{{ route('changeLanguage', 'cs') }}">
        Čeština (Nedokončeno)
    </x-dropdown-item>
</x-dropdown>
