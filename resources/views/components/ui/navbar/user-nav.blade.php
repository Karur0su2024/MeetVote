@auth
    <x-ui.dropdown.wrapper id="userDropdown" class="nav-item">
        <x-slot:header>
            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
        </x-slot:header>
        <x-slot:dropdownItems>
            <x-ui.dropdown.item href="{{ route('settings') }}">
                <i class="bi bi-gear me-1"></i> {{ __('navbar.settings') }}
            </x-ui.dropdown.item>
            <x-ui.dropdown.divider />
            <x-ui.dropdown.item class="text-danger" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right me-1"></i> {{ __('navbar.logout') }}
            </x-ui.dropdown.item>
        </x-slot:dropdownItems>
    </x-ui.dropdown.wrapper>
@else
    <x-ui.navbar.nav-link href="{{ route('login') }}">
        {{ __('navbar.login') }}
    </x-ui.navbar.nav-link>
    <x-ui.navbar.nav-link href="{{ route('register') }}">
        {{ __('navbar.register') }}
    </x-ui.navbar.nav-link>
@endauth
