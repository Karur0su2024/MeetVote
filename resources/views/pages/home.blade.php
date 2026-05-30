<x-layouts.app>
    <div>
        <div class="grid grid-cols-2 gap-1">
            <x-ui.card>
                <div class="card-body p-0">
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
            </x-ui.card>
            <img class="rounded-box shadow-sm"
                 src="{{ asset('images/homepage-image.png') }}" alt="MeetVote illustration">
        </div>


        <div class="mt-10">
            <div class="grid grid-cols-4 gap-1">
                <x-ui.card class="col-span-4">
                    <h3 class="text-2xl">{{ __('pages/homepage.section.two.title') }}</h3>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.simple.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.invite.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.sync.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.sync.text') }}
                    </p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.customizable.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.customizable.text') }}
                    </p>
                </x-ui.card>
            </div>
        </div>

        <div class="mt-10">
            <div class="grid grid-cols-4 gap-1">
                <x-ui.card class="col-span-4">
                    <h3 class="text-2xl">For who is MeetVote for
                    </h3>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.simple.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.invite.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.sync.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.sync.text') }}
                    </p>
                </x-ui.card>
                <x-ui.card class="col-span-2">
                    <h4 class="mb-2 text-lg">{{ __('pages/homepage.section.two.items.customizable.title') }}</h4>
                    <p class="font-light text-sm">{{ __('pages/homepage.section.two.items.customizable.text') }}
                    </p>
                </x-ui.card>
            </div>
        </div>
    </div>
</x-layouts.app>
