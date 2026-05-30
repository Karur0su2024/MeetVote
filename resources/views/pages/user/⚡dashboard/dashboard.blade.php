<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>{{ __('pages/dashboard.title') }}</x-slot>

    <div x-data="{ opened: 'Polls' }" class="flex flex-col gap-10">
        <x-ui.panel>
            <x-slot:left>
                <a href="{{ route('polls.create') }}"
                   class="btn btn-outline">
                    <i class="bi bi-plus-circle me-1"></i>
                    {{ __('pages/dashboard.buttons.new_poll') }}
                </a>
            </x-slot:left>
            <x-slot:right>
                <div x-show="opened === 'Polls'">
                    {{--                <x-ui.dropdown.wrapper size="md" color="outline">
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
                                    </x-ui.dropdown.wrapper>--}}

                    <button class="btn btn-outline btn-disabled">
                        {{ __('pages/dashboard.dropdowns.filter.title') }}
                    </button>
                </div>
                {{--                        <x-ui.dropdown.wrapper size="md" color="outline">
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
                                        </x-ui.dropdown.wrapper>--}}

                <button class="btn btn-outline btn-disabled">
                    {{ __('pages/dashboard.dropdowns.opened.items.polls') }}
                </button>
            </x-slot:right>
        </x-ui.panel>
        <div class="grid grid-cols-3 gap-1" x-show="opened === 'Polls'">
            <div class="col-span-3 card bg-base-100 shadow-sm p-3">
                <h3 class="text-xl ">{{ __('ui/navbar.dashboard') }}</h3>
            </div>

            @if (count($polls) !== 0)
                @foreach ($polls as $poll)
                    {{-- Karta ankety --}}
                    <x-ui.poll-card :poll="$poll"/>
                @endforeach
            @else
                {{-- Upozornění pro žádné ankety --}}
                <x-mary-alert title="{{ __('pages/dashboard.alerts.no_polls') }}"
                              class="alert-info alert-soft"
                              icon="o-information-circle"/>

            @endif
        </div>
        <div class="grid grid-cols-3 gap-1">
            <div class="col-span-3 card bg-base-100 shadow-sm p-3">
                <h3 class="text-xl ">{{ __('pages/dashboard.titles.voted_polls') }}</h3>
            </div>


            @foreach ($votes as $vote)
                {{-- Karta ankety --}}
                @if($vote->poll)
                    <x-ui.poll-card :poll="$vote->poll"/>
                @endif

            @endforeach
        </div>


        <div x-show="opened === 'Events'">
            @if (Auth::user()->google_id == null)
                {{-- Upozornění pro žádné události --}}
                <x-mary-alert title=""
                              class="alert-info"
                              icon="o-information-circle">
                    <x-slot:title>
                        {{ __('pages/dashboard.alerts.no_connected_calendar.text') }}
                        <a href="{{ route('settings') }}"
                           class="text-decoration-none">{{ __('pages/dashboard.alerts.no_connected_calendar.link') }}</a>.
                    </x-slot:title>
                </x-mary-alert>

            @endif


            @if(count($events) !== 0)
                <div class="grid grid-cols-3 gap-5">
                    @foreach($events as $event)
                        <x-ui.event-card :event="$event"/>
                    @endforeach
                </div>
            @else

                <x-mary-alert title="{{ __('pages/dashboard.alerts.no_events') }}"
                              class="alert-info alert-soft"
                              icon="o-calendar"/>
            @endif

        </div>
    </div>


</x-layouts.app>
