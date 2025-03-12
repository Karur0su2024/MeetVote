<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">MeetVote</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item p-0">
                    <a class="nav-link" href="{{ route('polls.create') }}">New Poll</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-secondary dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="py-1">
                                <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-check2-square me-1"></i> Your polls</a>
                            </li>
                            <li class="py-1">
                                <a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-1"></i> Settings</a>
                            </li>
                            <li class="py-1">
                                <a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
