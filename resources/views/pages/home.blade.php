<x-layouts.app>

    <!-- Název stránky -->


    @if(session()->has('warning'))
        <x-ui.alert type="warning">
            {{ session('warning') }}
        </x-ui.alert>
    @endif

    <div class="tw-max-w-7xl tw-mx-auto tw-p-4 tw-text-base-content">
        <div class="tw-card tw-card-side shadow-sm tw-bg-base-100">
            <div class="tw-card-body">
                <h2 class="mb-3 tw-text-3xl">{{ __('pages/homepage.section.one.title') }}</h2>
                <p class="tw-font-light mb-3">
                    {{__('pages/homepage.section.one.text') }}
                </p>
                <div class="tw-card-actions">
                    <a href="{{ route('polls.create') }}" class="tw-btn tw-btn-primary">
                        {{ __('pages/homepage.button.create_poll') }}
                    </a>
                </div>
            </div>
            <figure class="tw-max-w-2xl">
                <img src="{{ asset('images/homepage-image.png') }}" alt="MeetVote illustration">
            </figure>
        </div>
        <div class="p-3 tw-card shadow-mt mt-5">
            <div class="card-body">
                <h3 class="mb-3 tw-text-2xl">{{ __('pages/homepage.section.two.title') }}</h3>
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5 class="mb-2 tw-text-lg">{{ __('pages/homepage.section.two.items.simple.title') }}</h5>
                                <p class="tw-font-light">{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5 class="mb-2 tw-text-lg">{{ __('pages/homepage.section.two.items.invite.title') }}</h5>
                                <p class="tw-font-light">{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5 class="mb-2 tw-text-lg">{{ __('pages/homepage.section.two.items.sync.title') }}</h5>
                                <p class="tw-font-light">{{ __('pages/homepage.section.two.items.sync.text') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5 class="mb-2 tw-text-lg">{{ __('pages/homepage.section.two.items.customizable.title') }}</h5>
                                <p class="tw-font-light">{{ __('pages/homepage.section.two.items.customizable.text') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
