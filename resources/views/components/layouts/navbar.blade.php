{{--
TODO: Return dark mode toggle to the navbar

--}}

<nav class=" bg-gray-900 shadow-sm transition-all rounded-box text-white">
    <div class="navbar max-w-7xl mx-auto px-3 h-10  items-center">
        <div class="navbar-start gap-4">
            <a href="{{ route('home') }}"
               class="normal-case text-2xl flex items-center gap-3 px-2 transition-all m-0 rounded-lg">
                <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="w-7 h-7">
                <span class="font-bold tracking-tight">{{ config('app.name') }}</span>
            </a>
            <ul class="menu menu-horizontal hidden md:flex items-center m-0 gap-3">
                <li>
                    <a href="{{ route('polls.create') }}">
                        {{ __('ui/navbar.new_poll') }}
                    </a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('dashboard') }}">
                            {{ __('ui/navbar.dashboard') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
        <div class="navbar-end flex items-center gap-3">
            <ul class="menu menu-horizontal px-1 flex items-center gap-2 m-0">
                <x-mary-theme-toggle />
                <!-- Theme Toggle -->
                {{-- <li>
                    <label class="swap">
                        <input type="checkbox" class="theme-controller" value="dark" />
                        <i class="bi bi-brightness-high-fill swap-off h-10 w-10 text-2xl"></i>
                        <i class="bi bi-moon-fill swap-on h-10 w-10 text-2xl"></i>
                    </label>
                </li> --}}

                @auth
                    <div class="dropdown dropdown-end">
                        <button class="ps-4 rounded-box cursor-pointer" tabindex="0">
                            <x-ui.username :username="Auth::user()->name" />
                        </button>
                        <ul class="menu dropdown-content w-32 z-1 shadow-md bg-base-200 rounded-box  text-base-content"
                            tabindex="0">
                            <li>
                                <a href="{{ route('settings') }}">
                                    {{ __('ui/navbar.settings') }}
                                </a>
                            </li>
                            <li>
                                <form method="GET" action="{{ route('logout') }}">
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
