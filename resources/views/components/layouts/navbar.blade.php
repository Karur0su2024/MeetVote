<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-check2-square me-1"></i>MeetVote</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <x-nav-link href="{{ route('polls.create') }}">
                    Create poll
                </x-nav-link>
            </ul>
            <ul class="navbar-nav gap-2 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/Karur0su2024/MeetVote" title="Home">
                        <i class="bi bi-github"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ route('toggleDarkMode') }}">
                        @if (session('darkmode'))
                            <i class="bi bi-moon-fill"></i>
                        @else
                            <i class="bi bi-brightness-high-fill"></i>
                        @endif
                    </a>
                </li>

                <x-dropdown id="languageDropdown" class="nav-item">
                    <x-slot:header>
                        <i class="bi bi-globe me-1"></i> English
                    </x-slot:header>
                    <x-dropdown-item href="#">
                        English
                    </x-dropdown-item>
                    <x-dropdown-item href="#">
                        Čeština
                    </x-dropdown-item>
                </x-dropdown>


                @auth
                    <x-dropdown id="userDropdown" class="nav-item">
                        <x-slot:header>
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                        </x-slot:header>
                        <x-dropdown-item href="{{ route('dashboard') }}">
                            <i class="bi bi-check2-square me-1"></i> Your polls
                        </x-dropdown-item>
                        <x-dropdown-item href="{{ route('settings') }}">
                            <i class="bi bi-gear me-1"></i> Settings
                        </x-dropdown-item>
                        <x-dropdown-item class="text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </x-dropdown-item>
                    </x-dropdown>
                @else
                    <x-nav-link href="{{ route('login') }}">
                        Login
                    </x-nav-link>
                    <x-nav-link href="{{ route('register') }}">
                        Register
                    </x-nav-link>
                @endauth
            </ul>
        </div>
    </div>
</nav>
