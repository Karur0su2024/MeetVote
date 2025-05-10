{{-- Dashboard  uživatele --}}
<div class="text-start" x-data="{ opened: 'Polls' }">

    <div class="mb-3">
        <h3>{{ __('pages/dashboard.titles.voted_polls') }}</h3>
        <div class="row">
            @foreach ($votes as $vote)
                {{-- Karta ankety --}}
                @if($vote->poll)
                    <div class="col-md-6 col-lg-4">
                        <x-pages.dashboard.poll-card :poll="$vote->poll"/>
                    </div>
                @endif

            @endforeach
        </div>
    </div>

    <x-ui.panel>
        <x-slot:left>
            <a href="{{ route('polls.create') }}"
               class="btn btn-outline-secondary">
                <x-ui.icon name="plus-circle"/>
                {{ __('pages/dashboard.buttons.new_poll') }}
            </a>
        </x-slot:left>
        <x-slot:right>
            <div x-show="opened === 'Polls'">
                <x-ui.dropdown.wrapper size="md">
                    <x-slot:header>
                        <x-ui.icon name="filter"/>
                        {{ __('pages/dashboard.dropdowns.filter.title') }}
                    </x-slot:header>
                    <x-slot:dropdown-items>
                        <x-ui.dropdown.item wire:click="filterByStatus('all')"
                                            :class="$status === 'all' ? 'active' : ''">
                            {{ __('pages/dashboard.dropdowns.filter.items.all') }}
                        </x-ui.dropdown.item>
                        <x-ui.dropdown.item wire:click="filterByStatus('active')"
                                            :class="$status === 'active' ? 'active' : ''">
                            {{ __('pages/dashboard.dropdowns.filter.items.active') }}
                        </x-ui.dropdown.item>
                        <x-ui.dropdown.item wire:click="filterByStatus('closed')"
                                            :class="$status === 'closed' ? 'active' : ''">
                            {{ __('pages/dashboard.dropdowns.filter.items.closed') }}
                        </x-ui.dropdown.item>
                    </x-slot:dropdown-items>
                </x-ui.dropdown.wrapper>
            </div>
            <x-ui.dropdown.wrapper size="md">
                <x-slot:header><span
                        x-text="opened === 'Polls' ? '{{ __('pages/dashboard.dropdowns.opened.items.polls') }}' : '{{ __('pages/dashboard.dropdowns.opened.items.events') }}'"></span>
                </x-slot:header>
                <x-slot:dropdown-items>
                    <x-ui.dropdown.item @click="opened = 'Polls'"
                                        x-bind:class="opened === 'Polls' ? 'active' : ''">
                        {{ __('pages/dashboard.dropdowns.opened.items.polls') }}
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item @click="opened = 'Events'"
                                        x-bind:class="opened === 'Events' ? 'active' : ''">
                        {{ __('pages/dashboard.dropdowns.opened.items.events') }}
                    </x-ui.dropdown.item>
                </x-slot:dropdown-items>
            </x-ui.dropdown.wrapper>
        </x-slot:right>
    </x-ui.panel>




    <div x-show="opened === 'Polls'">
        <h3>{{ __('ui/navbar.dashboard') }}</h3>
        @if (count($polls) !== 0)
            <div class="row">
                @foreach ($polls as $poll)
                    {{-- Karta ankety --}}
                    <div class="col-md-6 col-lg-4">
                        <x-pages.dashboard.poll-card :poll="$poll"/>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Upozornění pro žádné ankety --}}
            <x-ui.alert type="info">
                <x-ui.icon name="info-circle" class="me-2"/>
                {{ __('pages/dashboard.alerts.no_polls') }}
            </x-ui.alert>
        @endif
    </div>


    <div x-show="opened === 'Events'">
        @if (Auth::user()->google_id == null)
            {{-- Upozornění pro žádné události --}}
            <x-ui.alert type="info">
                <x-ui.icon name="info-circle"/>
                {{ __('pages/dashboard.alerts.no_connected_calendar.text') }}
                <a href="{{ route('settings') }}"
                   class="text-decoration-none">{{ __('pages/dashboard.alerts.no_connected_calendar.link') }}</a>.
            </x-ui.alert>
        @endif


        @if(count($events) !== 0)
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <x-pages.dashboard.event-card :event="$event"/>
                    </div>
                @endforeach
            </div>
        @else
            <x-ui.alert type="info">
                <x-ui.icon name="bi-calendar-x"/>
                {{ __('pages/dashboard.alerts.no_events') }}
            </x-ui.alert>
        @endif

    </div>
</div>
