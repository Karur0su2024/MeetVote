<footer class=" bg-body-tertiary  py-4">
    <div class="container text-center">
        <p class="mb-2">&copy; 2024 Karel Tynek</p>

        <div class="d-flex justify-content-center align-items-center gap-3 mb-2">
            <a class="btn d-flex align-items-center gap-2" href="{{ route('toggleDarkMode') }}">
                @if (session('darkmode'))
                    <i class="bi bi-brightness-high"></i> Toggle light mode
                @else
                    <i class="bi bi-moon-fill"></i> Toggle dark mode
                @endif
            </a>

            <a class="btn d-flex align-items-center gap-2" href="https://github.com/Karur0su2024/MeetVote" target="_blank">
                <i class="bi bi-github"></i> GitHub Repository
            </a>
        </div>
    </div>
</footer>
