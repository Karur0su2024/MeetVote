<x-ui.dropdown.wrapper id="languageDropdown" class="nav-item">
    <x-slot:header>
        <i class="bi bi-globe me-1"></i> {{ __('ui/navbar.language') }}
    </x-slot:header>
    <x-slot:dropdownItems>
        <x-ui.dropdown.item href="{{ route('changeLanguage', 'en') }}">
            English
        </x-ui.dropdown.item>
        <x-ui.dropdown.item href="{{ route('changeLanguage', 'cs') }}">
            Čeština (Nedokončeno)
        </x-ui.dropdown.item>
    </x-slot:dropdownItems>
</x-ui.dropdown.wrapper>
