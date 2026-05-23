<footer class="bg-base-200 py-6 shadow-md text-base-content">
    <div class="container mx-auto text-center">

        <div class="flex flex-wrap justify-center items-center gap-2">
            <a href="{{ route('about') }}" class="link link-hover">
                About
            </a>
            <span class="mx-1 text-base-content/50">|</span>
            <a href="{{ route('privacy') }}" class="link link-hover">
                Privacy Policy
            </a>
            <span class="mx-1 text-base-content/50">|</span>
            <a href="{{ route('terms') }}" class="link link-hover">
                Terms of Service
            </a>
            <span class="mx-1 text-base-content/50">|</span>
            <div class="tooltip" data-tip="Not implemented yet">
                <a href="#" class="link link-hover opacity-50">
                    Admin Panel
                </a>
            </div>
            <span class="mx-1 text-base-content/50">|</span>
            <a href="https://github.com/Karur0su2024/MeetVote" class="link link-hover">
                Github Repository
            </a>

            <span class="mx-1 text-base-content/50">|</span>
            <div class="dropdown dropdown-top">
                <button class="hover:bg-primary/1" tabindex="0">
                    {{ __("ui/navbar.language") }}
                </button>

                <ul class="menu dropdown-content w-60 z-1 rounded-box bg-base-100 shadow-sm">
                    <li>
                        <a href="{{ route("changeLanguage", "en") }}">
                            English
                        </a>
                        <a href="{{ route("changeLanguage", "cz") }}">
                            Czech
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-4 text-xs text-base-content/50">
            {{ config('app.name') }} v{{ config('app.version') }} <br>
            &copy; {{ config('app.copyright.years') }} {{ config('app.copyright.author') }}
        </div>
    </div>
</footer>
