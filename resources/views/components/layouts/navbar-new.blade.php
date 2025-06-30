<nav class="tw-bg-base-100 tw-shadow-sm tw-border-b tw-border-base-200 tw-py-2 tw-transition-all">
    <div class="tw-navbar tw-max-w-7xl tw-mx-auto tw-px-4 tw-h-16 tw-flex tw-items-center">
        <div class="tw-navbar-start tw-gap-4">
            <a href="{{ route('dashboard') }}" class="tw-btn tw-btn-ghost tw-normal-case tw-text-2xl tw-flex tw-items-center tw-gap-3 tw-px-2 tw-transition-all tw-hover:bg-base-200 tw-rounded-lg">
                <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="tw-w-7 tw-h-7">
                <span class="tw-font-bold tw-tracking-tight">{{ config('app.name') }}</span>
            </a>
            <ul class="tw-menu tw-menu-horizontal tw-px-1 tw-hidden md:tw-flex tw-gap-1">
                <li>
                    <a href="{{ route('polls.create') }}" class="tw-hover:bg-primary/10 tw-rounded-lg tw-transition-all">
                        {{ __('ui/navbar.new_poll') }}
                    </a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'tw-active tw-font-semibold tw-bg-primary/10 tw-text-primary' : '' }} tw-hover:bg-primary/10 tw-rounded-lg tw-transition-all">
                            {{ __('ui/navbar.dashboard') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
        <div class="tw-navbar-end tw-flex tw-items-center tw-gap-3">
            <ul class="tw-menu tw-menu-horizontal tw-px-1 tw-flex tw-items-center tw-gap-2">
                <li>
                    <a href="https://github.com/Karur0su2024/MeetVote" target="_blank" class="tw-btn tw-btn-ghost tw-btn-sm tw-tooltip tw-transition-all tw-hover:bg-base-200 tw-rounded-lg" data-tip="GitHub">
                        <i class="bi bi-github tw-text-xl"></i>
                    </a>
                </li>
                <!-- Theme Toggle (odkomentuj pokud chceš použít) -->
                {{-- <li>
                    <label class="tw-swap">
                        <input type="checkbox" class="theme-controller" value="dark" />
                        <i class="bi bi-brightness-high-fill tw-swap-off tw-h-10 tw-w-10 tw-text-2xl"></i>
                        <i class="bi bi-moon-fill tw-swap-on tw-h-10 tw-w-10 tw-text-2xl"></i>
                    </label>
                </li> --}}
                <div class="tw-dropdown tw-dropdown-end">
                        {{ __("ui/navbar.language") }}
                    </button>

                    <ul class="tw-menu tw-dropdown-content tw-w-52 tw-z-1 tw-rounded-box tw-bg-base-100 tw-shadow-sm">
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
                @auth
                    <div class="tw-dropdown tw-dropdown-end">
                        <button class="tw-btn tw-btn-ghost tw-btn-sm tw-flex tw-items-center tw-gap-2" tabindex="0">
                            <div class="tw-avatar tw-avatar-placeholder">
                                <div class="tw-w-6 tw-rounded-full tw-bg-neutral tw-text-neutral-content tw-flex tw-items-center tw-justify-center">
                                            <span class="tw-text-sm">
                                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                                            </span>
                                </div>
                            </div>
                            <span class="tw-text-sm">
                                        {{ Auth::user()->name }}
                                    </span>
                        </button>
                        <ul class="tw-menu tw-dropdown-content tw-w-52 tw-z-1 tw-shadow-sm tw-bg-base-100 tw-rounded-box" tabindex="0">
                            <li>
                                <a href="{{ route('settings') }}">
                                    {{ __('ui/navbar.settings') }}
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="tw-w-full tw-text-left">
                                        {{ __('ui/navbar.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <li>
                        <a href="{{ route("login") }}">{{ __("ui/navbar.login") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("register") }}">{{ __("ui/navbar.register") }}</a>
                    </li>
                @endauth

            </ul>

        </div>

    </div>

</nav>
