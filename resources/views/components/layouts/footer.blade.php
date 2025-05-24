<footer class="bg-body-tertiary py-4 shadow-sm bg-base-100">
    <div class="container text-center">
        <p class="mb-2">&copy; 2025 Karel Tynek</p>
        <p>
            {{ __('ui/footer.copyright') }}
        </p>
        <div>
            <a href="{{ route('about') }}" class="btn btn-link">
                About
            </a>
            <span class="mx-2">|</span>
            <a href="{{ route('privacy') }}" class="btn btn-link">
                Privacy Policy
            </a>
            <span class="mx-2">|</span>
            <a href="{{ route('terms') }}" class="btn btn-link">
                Terms of Service
            </a>
            <span class="mx-2">|</span>
            <a href="https://github.com/Karur0su2024/MeetVote" class="btn btn-link">
                Github Repository
            </a>
        </div>

    </div>
</footer>
