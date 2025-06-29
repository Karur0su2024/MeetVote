<div class="bg-base-100 shadow-sm">
    <div class="navbar max-w-7xl mx-auto">
        <div class="navbar-start">
            <a class="btn btn-ghost text-xl">
                <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="w-8 h-8 mr-2">
                {{ config('app.name') }}
            </a>
            <ul class="menu menu-horizontal px-1">
                <li>
                    <a href="{{ route('polls.create') }}">{{ __('ui/navbar.new_poll') }}</a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('dashboard') }}">{{ __('ui/navbar.dashboard') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
        <div class="navbar-end flex items-center gap-2">
            <ul class="menu menu-horizontal px-1 flex gap-2">
                <li>
                    <a href="github.com/Karur0su2024/MeetVote" class="btn btn-ghost btn-sm">
                        <i class="bi bi-github text-xl"></i>
                    </a>
                </li>

                <!-- Theme Toggle -->
                {{--            <div class="dropdown dropdown-end">--}}
                {{--                <div tabindex="0" role="button" class="btn btn-ghost btn-sm">--}}
                {{--                    <i id="darkmode-toggle-icon"></i>--}}
                {{--                </div>--}}
                {{--                <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-32">--}}
                {{--                    <li>--}}
                {{--                        <input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Light" value="light"/>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Dark" value="dark"/>--}}
                {{--                    </li>--}}
                {{--                </ul>--}}
                {{--            </div>--}}
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
                        <button class="btn btn-ghost btn-sm">
                            <div class="flex-row gap-2">
                                <div class="avatar avatar-placeholder">
                                    <div class="w-6 rounded-full bg-neutral text-neutral-content">
                                        <span class="text-sm">K</span>
                                    </div>
                                </div>
                                <span class="text-sm">
                                    {{ Auth::user()->name }}
                                </span>
                            </div>
                        </button>
                        <ul class="menu dropdown-content w-52 z-1 shadow-sm bg-base-100 rounded-box">
                           <li>
                               <a href="{{ route("settings") }}">
                                   {{ __("ui/navbar.settings") }}
                               </a>
                           </li>
                            <li>
                                <a href="{{ route("logout") }}">{{ __("ui/navbar.logout") }}</a>
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

</div>

