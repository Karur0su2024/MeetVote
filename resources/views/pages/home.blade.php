<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/homepage.title') }}</x-slot>

    @if(session()->has('warning'))
        <x-ui.alert type="warning">
            {{ session('warning') }}
        </x-ui.alert>
    @endif

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="p-4">
                            <h2 class="mb-3">{{ __('pages/homepage.section.one.title') }}</h2>
                            <p class="lead">
                                {{__('pages/homepage.section.one.text') }}
                            </p>
                            <a href="{{ route('polls.create') }}" class="btn btn-primary">
                                {{ __('pages/homepage.button.create_poll') }}
                            </a>
                        </div>

                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 text-center">
                        <img src="{{ asset('images/homepage-image.png') }}" alt="MeetVote illustration" class="img-fluid rounded w-100" style="max-height: 300px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 card shadow-mt mt-5">
            <div class="card-body">
                <h3>{{ __('pages/homepage.section.two.title') }}</h3>
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5>{{ __('pages/homepage.section.two.items.simple.title') }}</h5>
                                <p>{{ __('pages/homepage.section.two.items.simple.text') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5>{{ __('pages/homepage.section.two.items.invite.title') }}</h5>
                                <p>{{ __('pages/homepage.section.two.items.invite.text') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5>{{ __('pages/homepage.section.two.items.sync.title') }}</h5>
                                <p>{{ __('pages/homepage.section.two.items.sync.text') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div>
                                <h5>{{ __('pages/homepage.section.two.items.customizable.title') }}</h5>
                                <p>{{ __('pages/homepage.section.two.items.customizable.text') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 card shadow-mt mt-5">
            <div class="card-body">
                <h3>{{ __('pages/homepage.section.three.title') }}</h3>
                <p>
                    {{ __('pages/homepage.section.three.text', ['email' => config('app.author_mail')]) }}
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
