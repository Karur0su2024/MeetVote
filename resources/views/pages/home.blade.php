<x-layouts.app>

    <!-- Název stránky -->


    @if(session()->has('warning'))
        <x-ui.alert type="warning">
            {{ session('warning') }}
        </x-ui.alert>
    @endif

    <div>
        <div class="card card-side shadow-sm bg-base-100">
            <div class="card-body">
                <h2 class="mb-3 text-3xl">{{ __('pages/homepage.section.one.title') }}</h2>
                <p class="font-light mb-3">
                    {{__('pages/homepage.section.one.text') }}
                </p>
                <div class="card-actions">
                    <a href="{{ route('polls.create') }}" class="btn btn-primary">
                        {{ __('pages/homepage.button.create_poll') }}
                    </a>
                </div>
            </div>
            <figure class="max-w-2xl">
                <img src="{{ asset('images/homepage-image.png') }}" alt="MeetVote illustration">
            </figure>
        </div>
        <div class="p-3 card shadow-sm mt-5 bg-base-100">
            <div class="p-4">
                <h3 class="mb-3 text-2xl">{{ __('pages/homepage.section.two.title') }}</h3>
                <div class="grid mt-4 grid-cols-2 gap-8">
                    <div class="mb-4">
                        <h5 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.simple.title') }}</h5>
                        <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.invite.title') }}</h5>
                        <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.sync.title') }}</h5>
                        <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.sync.text') }}
                        </p>
                    </div>
                    <div class="mb-4">
                        <h5 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.customizable.title') }}</h5>
                        <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.customizable.text') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
