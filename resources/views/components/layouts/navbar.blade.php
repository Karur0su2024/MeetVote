<nav class="bg-base-100 shadow-sm">
    <div class="navbar max-w-7xl mx-auto">
        <div class="navbar-start gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl flex items-center gap-2 px-2">
                <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="w-8 h-8">
                <span class="font-bold tracking-tight">{{ config('app.name') }}</span>
            </a>
            <ul class="menu menu-horizontal px-1 hidden md:flex">
                <li>
                    <a href="{{ route('polls.create') }}" class="hover:bg-base-200 rounded-lg">
                        {{ __('ui/navbar.new_poll') }}
                    </a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active font-semibold' : '' }} hover:bg-base-200 rounded-lg">
                            {{ __('ui/navbar.dashboard') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
        <div class="navbar-end flex items-center gap-2">
            <ul class="menu menu-horizontal px-1 flex items-center gap-2">
                <li>
                    <a href="https://github.com/Karur0su2024/MeetVote" target="_blank" class="btn btn-ghost btn-sm tooltip text-lg" data-tip="GitHub">
                        <i class="bi bi-github"></i>
                    </a>
                </li>
                <li>
                    <label class="swap">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" class="theme-controller" value="dark" />

                        <!-- sun icon -->
                        <i class="bi bi-brightness-high-fill swap-off h-10 w-10 text-2xl"></i>

                        <!-- moon icon -->
                        <i class="bi bi-moon-fill swap-on h-10 w-10 text-2xl"></i>
                    </label>
                </li>
                <!-- Theme Toggle -->

                <div class="dropdown dropdown-end">
                    <button role="button" class="btn btn-sm btn-ghost">
                        {{ __("ui/navbar.language") }}
                    </button>

                    <ul class="menu dropdown-content w-52 z-1 rounded-box bg-base-200 shadow-sm">
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
<div class="dropdown dropdown-end">
                                <button class="btn btn-ghost btn-sm flex items-center gap-2" tabindex="0">
                                    <div class="avatar avatar-placeholder">
                                        <div class="w-6 rounded-full bg-neutral text-neutral-content flex items-center justify-center">
                                            <span class="text-sm">
                                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-sm">
                                        {{ Auth::user()->name }}
                                    </span>
                                </button>
                                <ul class="menu dropdown-content w-52 z-1 shadow-sm bg-base-100 rounded-box" tabindex="0">
                                    <li>
                                        <a href="{{ route('settings') }}">
                                            {{ __('ui/navbar.settings') }}
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left">
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

