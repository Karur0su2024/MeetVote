<footer class="tw-bg-base-200 tw-py-6 tw-shadow-md tw-text-base-content">
    <div class="tw-container tw-mx-auto tw-text-center">
        <p class="tw-mb-2 tw-text-sm tw-text-base-content/70">&copy; 2025-2026 Karel Tynek</p>
        <p class="tw-mb-4 tw-text-base-content/80">
            {{ __('ui/footer.copyright') }}
        </p>
        <div class="tw-flex tw-flex-wrap tw-justify-center tw-items-center tw-gap-2">
            <a href="{{ route('about') }}" class="tw-link tw-link-hover">
                About
            </a>
            <span class="tw-mx-1 tw-text-base-content/50">|</span>
            <a href="{{ route('privacy') }}" class="tw-link tw-link-hover">
                Privacy Policy
            </a>
            <span class="tw-mx-1 tw-text-base-content/50">|</span>
            <a href="{{ route('terms') }}" class="tw-link tw-link-hover">
                Terms of Service
            </a>
            <span class="tw-mx-1 tw-text-base-content/50">|</span>
            <div class="tw-tooltip" data-tip="Not implemented yet">
                <a href="#" class="tw-link tw-link-hover tw-opacity-50">
                    Admin Panel
                </a>
            </div>
            <span class="tw-mx-1 tw-text-base-content/50">|</span>
            <a href="https://github.com/Karur0su2024/MeetVote" class="tw-link tw-link-hover">
                Github Repository
            </a>

            <span class="tw-mx-1 tw-text-base-content/50">|</span>
            <div class="tw-dropdown tw-dropdown-top">
                <button class="tw-hover:bg-primary/1" tabindex="0">
                    {{ __("ui/navbar.language") }}
                </button>

                <ul class="tw-menu tw-dropdown-content tw-w-60 tw-z-1 tw-rounded-box tw-bg-base-100 tw-shadow-sm">
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
        <div class="tw-mt-4 tw-text-xs tw-text-base-content/50">
            Meetvote v0.2.0 <br>
            &copy; 2025-2026 Karel Tynek
        </div>
    </div>
</footer>
