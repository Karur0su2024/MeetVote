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
                    {{ __('navbar.new_poll') }}
                </x-nav-link>
            </ul>
            <ul class="navbar-nav gap-2 align-items-center">
                <x-nav-link href="https://github.com/Karur0su2024/MeetVote">
                    <i class="bi bi-github"></i>
                </x-nav-link>
                <x-ui.navbar.theme-settings/>
                <x-ui.navbar.language-settings/>
                <x-ui.navbar.user-nav/>
            </ul>
        </div>
    </div>
</nav>
