<x-layouts.navbar-container class="bg-gray-900 shadow-sm transition-all rounded-box">

    <x-slot:brand>
        <a href="{{ route('home') }}"
           class="normal-case text-2xl flex items-center gap-3 px-2 transition-all m-0 rounded-lg">
            <img src="{{ asset('images/app-logo.png') }}" alt="logo" class="w-7 h-7">
            <span class="font-bold tracking-tight">{{ config('app.name') }}</span>
        </a>
    </x-slot:brand>


    <x-slot:left-side-actions>
        <a href="{{ route('polls.create') }}">
            {{ __('ui/navbar.new_poll') }}
        </a>
    </x-slot:left-side-actions>

    {{-- Right side actions --}}
    <x-slot:rightSideActions>
        <!-- Theme Toggle -->
        <x-mary-theme-toggle class="text-white p-2"/>
        @auth
            <x-mary-dropdown>
                <x-slot:trigger>
                    <button class="rounded-box cursor-pointer text-white" tabindex="0">
                        <x-ui.username :username="Auth::user()->name"/>
                    </button>
                </x-slot:trigger>
                <x-mary-menu-item class="text-base-content" title="{{ __('ui/navbar.dashboard') }}"
                                  href="{{ route('dashboard') }}"/>
                <x-mary-menu-item class="text-base-content" title="{{ __('ui/navbar.settings') }}"
                                  href="{{ route('settings') }}"/>
                <x-mary-menu-separator class="text-base-content"/>
                <x-mary-menu-item class="text-base-content" href="{{ route('settings') }}">
                    <form method="GET" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left">
                            {{ __('ui/navbar.logout') }}
                        </button>
                    </form>
                </x-mary-menu-item>
            </x-mary-dropdown>
        @else
            <a class="text-white" href="{{ route("login") }}">{{ __("ui/navbar.login") }}</a>
            <a class="text-white" href="{{ route("register") }}">{{ __("ui/navbar.register") }}</a>
        @endauth

    </x-slot:rightSideActions>
</x-layouts.navbar-container>


