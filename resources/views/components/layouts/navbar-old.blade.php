<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/app-logo.png') }}" alt="logo" width="30" height="30" class="me-1">
            {{ config('app.name') }}</a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <x-ui.navbar.nav-link href="{{ route('polls.create') }}">
                    {{ __('ui/navbar.new_poll') }}
                </x-ui.navbar.nav-link>
                @auth
                    <x-ui.navbar.nav-link href="{{ route('dashboard') }}">
                        {{ __('ui/navbar.dashboard') }}
                    </x-ui.navbar.nav-link>
                @endauth
            </ul>
            <ul class="navbar-nav gap-2 align-items-center">
                <x-ui.navbar.nav-link href="https://github.com/Karur0su2024/MeetVote">
                    <i class="bi bi-github"></i>
                </x-ui.navbar.nav-link>
                <x-ui.navbar.theme-settings/>
                <x-ui.navbar.language-settings/>
                @auth
                    <x-ui.dropdown.wrapper id="userDropdown" class="nav-item">
                        <x-slot:header>
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </x-slot:header>
                        <x-slot:dropdownItems>
                            <x-ui.dropdown.item href="{{ route('settings') }}">
                                <i class="bi bi-gear me-1"></i> {{ __('ui/navbar.settings') }}
                            </x-ui.dropdown.item>
                            <x-ui.dropdown.divider/>
                            <x-ui.dropdown.item class="text-danger" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right me-1"></i> {{ __('ui/navbar.logout') }}
                            </x-ui.dropdown.item>
                        </x-slot:dropdownItems>
                    </x-ui.dropdown.wrapper>
                @else
                    <x-ui.navbar.nav-link href="{{ route('login') }}">
                        {{ __('ui/navbar.login') }}
                    </x-ui.navbar.nav-link>
                    <x-ui.navbar.nav-link href="{{ route('register') }}">
                        {{ __('ui/navbar.register') }}
                    </x-ui.navbar.nav-link>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<div class="dropdown">
    <button class="btn btn-ghost btn-sm">{{ Auth::user()->name }}</button>
    <ul class="menu dropdown-content bg-base-100 rounded-box shadow-lg mt-2">
        @auth
            <li>
                <a href="{{ route('settings') }}" class="dropdown-item">
                    <i class="bi bi-gear
                                        me-1"></i> {{ __('ui/navbar.settings') }}
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-1"></i> {{ __('ui/navbar.logout') }}
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}" class="dropdown-item">
                    {{ __('ui/navbar.login') }}
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="dropdown-item">
                    {{ __('ui/navbar.register') }}
                </a>
            </li>
        @endauth

    </ul>
</div>
