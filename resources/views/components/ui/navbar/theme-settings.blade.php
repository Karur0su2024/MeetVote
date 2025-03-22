<li class="nav-item">
    <a class="nav-link" href="{{ route('toggleDarkMode') }}">
        @if (session('darkmode'))
            <i class="bi bi-moon-fill"></i>
        @else
            <i class="bi bi-brightness-high-fill"></i>
        @endif
    </a>
</li>
