<x-layouts.app-new>

    @if(session()->has('warning'))
        <x-ui.alert type="warning">
            {{ session('warning') }}
        </x-ui.alert>
    @endif


    <div class="px-12 space-y-12">
        <div class="hero bg-base-200 rounded-2 shadow-md">
            <div class="hero-content flex-col lg:flex-row p-0">
                <div class="px-8">
                    <h2 class="text-3xl font-bold">{{ __('pages/homepage.section.one.title') }}</h2>
                    <p class="py-6">{{__('pages/homepage.section.one.text') }}</p>
                    <a href="{{ route('polls.create') }}" class="btn btn-primary btn-md">
                        {{ __('pages/homepage.button.create_poll') }}
                    </a>
                </div>
                <img src="{{ asset('images/homepage-image.png') }}" alt="MeetVote"
                     class="max-w-2xl rounded-lg">
            </div>
        </div>

        <div class="hero bg-base-200 rounded-2 shadow-md">
            <div class="hero-content flex-col lg:flex-row p-8 gap-8">
                <div class="w-full">
                    <h2 class="text-3xl font-bold mb-6 text-center lg:text-left">
                        {{ __('pages/homepage.section.two.title') }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            class="flex flex-col items-center text-center bg-base-100 rounded-xl p-6 shadow hover:shadow-lg transition">
                            <h5 class="font-semibold mb-2">{{ __('pages/homepage.section.two.items.simple.title') }}</h5>
                            <p class="text-sm">{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                        </div>
                        <div
                            class="flex flex-col items-center text-center bg-base-100 rounded-xl p-6 shadow hover:shadow-lg transition">
                            <h5 class="font-semibold mb-2">{{ __('pages/homepage.section.two.items.invite.title') }}</h5>
                            <p class="text-sm">{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                        </div>
                        <div
                            class="flex flex-col items-center text-center bg-base-100 rounded-xl p-6 shadow hover:shadow-lg transition">
                            <h5 class="font-semibold mb-2">{{ __('pages/homepage.section.two.items.sync.title') }}</h5>
                            <p class="text-sm">{{ __('pages/homepage.section.two.items.sync.text') }}</p>
                        </div>
                        <div
                            class="flex flex-col items-center text-center bg-base-100 rounded-xl p-6 shadow hover:shadow-lg transition">
                            <h5 class="font-semibold mb-2">{{ __('pages/homepage.section.two.items.customizable.title') }}</h5>
                            <p class="text-sm">{{ __('pages/homepage.section.two.items.customizable.text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app-new>
