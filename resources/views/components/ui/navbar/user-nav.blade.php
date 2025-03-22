@auth
    <x-dropdown id="userDropdown" class="nav-item">
        <x-slot:header>
            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
        </x-slot:header>
        <x-dropdown-item href="{{ route('dashboard') }}">
            <i class="bi bi-check2-square me-1"></i> {{ __('navbar.dashboard') }}
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('settings') }}">
            <i class="bi bi-gear me-1"></i> {{ __('navbar.settings') }}
        </x-dropdown-item>
        <x-dropdown-item class="text-danger" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right me-1"></i> {{ __('navbar.logout') }}
        </x-dropdown-item>
    </x-dropdown>
@else
    <x-nav-link href="{{ route('login') }}">
        {{ __('navbar.login') }}
    </x-nav-link>
    <x-nav-link href="{{ route('register') }}">
        {{ __('navbar.register') }}
    </x-nav-link>
@endauth
