{{--<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-md">--}}
{{--    <div class="container">--}}

{{--        <a class="navbar-brand fw-bold" href="{{ route('home') }}">--}}
{{--            <img src="{{ asset('images/app-logo.png') }}" alt="logo" width="30" height="30" class="me-1">--}}
{{--            {{ config('app.name') }}</a>--}}
{{--        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"--}}
{{--                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
{{--        <div class="collapse navbar-collapse" id="navbarNav">--}}
{{--            <ul class="navbar-nav me-auto">--}}
{{--                <x-ui.navbar.nav-link href="{{ route('polls.create') }}">--}}
{{--                    {{ __('ui/navbar.new_poll') }}--}}
{{--                </x-ui.navbar.nav-link>--}}
{{--                @auth--}}
{{--                    <x-ui.navbar.nav-link href="{{ route('dashboard') }}">--}}
{{--                        {{ __('ui/navbar.dashboard') }}--}}
{{--                    </x-ui.navbar.nav-link>--}}
{{--                @endauth--}}
{{--            </ul>--}}
{{--            <ul class="navbar-nav gap-2 align-items-center">--}}
{{--                <x-ui.navbar.nav-link href="https://github.com/Karur0su2024/MeetVote">--}}
{{--                    <i class="bi bi-github"></i>--}}
{{--                </x-ui.navbar.nav-link>--}}
{{--                <x-ui.navbar.theme-settings/>--}}
{{--                <x-ui.navbar.language-settings/>--}}
{{--                <x-ui.navbar.user-nav/>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}

<div class="bg-base-100 shadow-sm">
    <div class="navbar max-w-7xl mx-auto">
        <div class="navbar-start">

            <a class="btn btn-ghost text-xl font-bold" href="{{ route('home') }}">
                <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="w-8 h-8 mr-2">
                {{ config('app.name') }}
            </a>
            <ul class="menu menu-horizontal px-1">
                <li><a href="{{ route('polls.create') }}">{{ __('ui/navbar.new_poll') }}</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}">{{ __('ui/navbar.dashboard') }}</a></li>
                @endauth
            </ul>
        </div>

        <div class="navbar-end">
            <div class="flex items-center gap-3">
                <!-- GitHub Link -->
                <a href="https://github.com/Karur0su2024/MeetVote" class="btn btn-ghost btn-sm">
                    <i class="bi bi-github text-xl"></i>
                </a>


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
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                        {{ __('ui/navbar.language') }}
                    </div>
                    <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-32">
                        <li><a href="{{ route('changeLanguage', 'en') }}">English</a></li>
                        <li><a href="{{ route('changeLanguage', 'cs') }}">Čeština</a></li>
                    </ul>
                </div>

                @auth
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                            <div class="avatar">
                                <div class="w-8 rounded-full">
                                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-primary-content">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </div>
                            </div>
                            {{ Auth::user()->name }}
                        </div>
                        <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a href="{{ route('settings') }}">{{ __('ui/navbar.settings') }}</a></li>
                            <div class="divider my-1"></div>
                            <li><a href="{{ route('logout') }}" class="text-error">{{ __('ui/navbar.logout') }}</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm">{{ __('ui/navbar.login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('ui/navbar.register') }}</a>
                @endauth
            </div>
        </div>
    </div>

</div>
