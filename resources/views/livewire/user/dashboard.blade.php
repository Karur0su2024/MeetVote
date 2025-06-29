{{-- Dashboard  uživatele --}}
<div x-data="{ opened: 'Polls' }">
    <div class="my-5">
        <h3 class="text-3xl">
            {{ __('pages/dashboard.titles.voted_polls') }}
        </h3>
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 p-1 bg-base-100 shadow rounded-box mt-4 mb-2">
            <div>
                <a href="{{ route('polls.create') }}"
                   class="btn btn-outline btn-secondary">
                    <x-ui.icon name="plus-circle"/>
                    {{ __('pages/dashboard.buttons.new_poll') }}
                </a>
            </div>
            <div class="flex gap-2 items-center">
                <div x-show="opened === 'Polls'">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-md btn-outline btn-primary flex items-center gap-2">
                            <x-ui.icon name="filter"/>
                            {{ __('pages/dashboard.dropdowns.filter.title') }}
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a wire:click="filterByStatus('all')"
                                   class="{{ $status === 'all' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.all') }}
                                </a>
                            </li>
                            <li>
                                <a wire:click="filterByStatus('active')"
                                   class="{{ $status === 'active' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.active') }}
                                </a>
                            </li>
                            <li>
                                <a wire:click="filterByStatus('closed')"
                                   class="{{ $status === 'closed' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.closed') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-md btn-outline btn-primary">
                        <span x-text="opened === 'Polls' ? '{{ __('pages/dashboard.dropdowns.opened.items.polls') }}' : '{{ __('pages/dashboard.dropdowns.opened.items.events') }}'"></span>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li>
                            <a @click="opened = 'Polls'"
                               :class="opened === 'Polls' ? 'active' : ''">
                                {{ __('pages/dashboard.dropdowns.opened.items.polls') }}
                            </a>
                        </li>
                        <li>
                            <a @click="opened = 'Events'"
                               :class="opened === 'Events' ? 'active' : ''">
                                {{ __('pages/dashboard.dropdowns.opened.items.events') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{--            @foreach ($votes as $vote)--}}
        {{--                --}}{{-- Karta ankety --}}
        {{--                @if($vote->poll)--}}
        {{--                    <div class="col-md-6 col-lg-4">--}}
        {{--                        <x-pages.dashboard.poll-card :poll="$vote->poll"/>--}}
        {{--                    </div>--}}
        {{--                @endif--}}

        {{--            @endforeach--}}

        @if (count($polls) !== 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($polls as $poll)
                            {{-- Karta ankety --}}
                            <div class="card bg-base-100 shadow-md border">
                                <div class="card-body p-4 flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <h4 class="card-title break-words">
                                                {{ $poll->title }}
                                            </h4>
                                        </div>
                                        @can('is-admin', $poll)
                                            <div class="dropdown dropdown-end">
                                                <label tabindex="0" class="btn btn-ghost btn-circle">
                                                    <i class="bi bi-three-dots"></i>
                                                </label>
                                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                                    <li>
                                                        <a href="{{ route('polls.edit', $poll) }}" class="{{ !$poll->isActive() ? 'disabled pointer-events-none opacity-50' : '' }}">
                                                            <x-ui.icon name="pencil"/>
                                                            {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" wire:click="openModal('modals.poll.share', '{{ $poll->id }}')" class="w-full text-left">
                                                            <x-ui.icon name="share"/>
                                                            {{ __('pages/dashboard.poll_card.dropdown.share') }}
                                                        </button>
                                                    </li>
                                                    <li><hr class="my-1"></li>
                                                    <li>
                                                        <button type="button" wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')" class="w-full text-left text-error">
                                                            <x-ui.icon name="trash"/>
                                                            {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endcan
                                    </div>
                                    <div class="flex gap-2 items-center flex-wrap mb-2">
                                        <span class="badge {{ $poll->isActive() ? 'badge-success' : 'badge-ghost' }}">
                                            {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                                        </span>
                                        @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
                                            <span class="badge badge-info">
                                                {{ __('pages/dashboard.poll_card.pills.voted') }}
                                            </span>
                                        @endif
                                        @can('is-admin', $poll)
                                            <span class="badge badge-warning">
                                                {{ __('pages/dashboard.poll_card.pills.admin') }}
                                            </span>
                                        @endcan
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 text-center">
                                        <div>
                                            <i class="bi bi-check-circle text-2xl"></i>
                                            <div class="font-bold">{{ $poll->votes()->count() }}</div>
                                            <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>
                                        </div>
                                        <div>
                                            <i class="bi bi-clock text-2xl"></i>
                                            <div class="font-bold">{{ $poll->timeOptions()->count() }}</div>
                                            <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>
                                        </div>
                                        <div>
                                            <i class="bi bi-question-circle text-2xl"></i>
                                            <div class="font-bold">{{ $poll->questions()->count() }}</div>
                                            <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-actions justify-end p-4 pt-0">
                                    <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">
                                        {{ __('pages/dashboard.poll_card.buttons.view') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

    </div>
</div>

{{--<div class="text-start">--}}

{{--    <div class="mb-3">--}}
{{--        <div class="row">--}}
{{--            @foreach ($votes as $vote)--}}
{{--                --}}{{-- Karta ankety --}}
{{--                @if($vote->poll)--}}
{{--                    <div class="col-md-6 col-lg-4">--}}
{{--                        <x-pages.dashboard.poll-card :poll="$vote->poll"/>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <x-ui.panel>--}}
{{--        <x-slot:left>--}}
{{--            <a href="{{ route('polls.create') }}"--}}
{{--               class="btn btn-outline-secondary">--}}
{{--                <x-ui.icon name="plus-circle"/>--}}
{{--                {{ __('pages/dashboard.buttons.new_poll') }}--}}
{{--            </a>--}}
{{--        </x-slot:left>--}}
{{--        <x-slot:right>--}}
{{--            <div x-show="opened === 'Polls'">--}}
{{--                <x-ui.dropdown.wrapper size="md">--}}
{{--                    <x-slot:header>--}}
{{--                        <x-ui.icon name="filter"/>--}}
{{--                        {{ __('pages/dashboard.dropdowns.filter.title') }}--}}
{{--                    </x-slot:header>--}}
{{--                    <x-slot:dropdown-items>--}}
{{--                        <x-ui.dropdown.item wire:click="filterByStatus('all')"--}}
{{--                                            :class="$status === 'all' ? 'active' : ''">--}}
{{--                            {{ __('pages/dashboard.dropdowns.filter.items.all') }}--}}
{{--                        </x-ui.dropdown.item>--}}
{{--                        <x-ui.dropdown.item wire:click="filterByStatus('active')"--}}
{{--                                            :class="$status === 'active' ? 'active' : ''">--}}
{{--                            {{ __('pages/dashboard.dropdowns.filter.items.active') }}--}}
{{--                        </x-ui.dropdown.item>--}}
{{--                        <x-ui.dropdown.item wire:click="filterByStatus('closed')"--}}
{{--                                            :class="$status === 'closed' ? 'active' : ''">--}}
{{--                            {{ __('pages/dashboard.dropdowns.filter.items.closed') }}--}}
{{--                        </x-ui.dropdown.item>--}}
{{--                    </x-slot:dropdown-items>--}}
{{--                </x-ui.dropdown.wrapper>--}}
{{--            </div>--}}
{{--            <x-ui.dropdown.wrapper size="md">--}}
{{--                <x-slot:header><span--}}
{{--                        x-text="opened === 'Polls' ? '{{ __('pages/dashboard.dropdowns.opened.items.polls') }}' : '{{ __('pages/dashboard.dropdowns.opened.items.events') }}'"></span>--}}
{{--                </x-slot:header>--}}
{{--                <x-slot:dropdown-items>--}}
{{--                    <x-ui.dropdown.item @click="opened = 'Polls'"--}}
{{--                                        x-bind:class="opened === 'Polls' ? 'active' : ''">--}}
{{--                        {{ __('pages/dashboard.dropdowns.opened.items.polls') }}--}}
{{--                    </x-ui.dropdown.item>--}}
{{--                    <x-ui.dropdown.item @click="opened = 'Events'"--}}
{{--                                        x-bind:class="opened === 'Events' ? 'active' : ''">--}}
{{--                        {{ __('pages/dashboard.dropdowns.opened.items.events') }}--}}
{{--                    </x-ui.dropdown.item>--}}
{{--                </x-slot:dropdown-items>--}}
{{--            </x-ui.dropdown.wrapper>--}}
{{--        </x-slot:right>--}}
{{--    </x-ui.panel>--}}


{{--    <div x-show="opened === 'Polls'">--}}
{{--        <h3>{{ __('ui/navbar.dashboard') }}</h3>--}}
{{--        @if (count($polls) !== 0)--}}
{{--            <div class="row">--}}
{{--                @foreach ($polls as $poll)--}}
{{--                    --}}{{-- Karta ankety --}}
{{--                    <div class="col-md-6 col-lg-4">--}}
{{--                        <x-pages.dashboard.poll-card :poll="$poll"/>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @else--}}
{{--            --}}{{-- Upozornění pro žádné ankety --}}
{{--            <x-ui.alert type="info">--}}
{{--                <x-ui.icon name="info-circle" class="me-2"/>--}}
{{--                {{ __('pages/dashboard.alerts.no_polls') }}--}}
{{--            </x-ui.alert>--}}
{{--        @endif--}}
{{--    </div>--}}


{{--    <div x-show="opened === 'Events'">--}}
{{--        @if (Auth::user()->google_id == null)--}}
{{--            --}}{{-- Upozornění pro žádné události --}}
{{--            <x-ui.alert type="info">--}}
{{--                <x-ui.icon name="info-circle"/>--}}
{{--                {{ __('pages/dashboard.alerts.no_connected_calendar.text') }}--}}
{{--                <a href="{{ route('settings') }}"--}}
{{--                   class="text-decoration-none">{{ __('pages/dashboard.alerts.no_connected_calendar.link') }}</a>.--}}
{{--            </x-ui.alert>--}}
{{--        @endif--}}


{{--        @if(count($events) !== 0)--}}
{{--            <div class="row g-4">--}}
{{--                @foreach($events as $event)--}}
{{--                    <div class="col-lg-4 col-md-6">--}}
{{--                        <x-pages.dashboard.event-card :event="$event"/>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @else--}}
{{--            <x-ui.alert type="info">--}}
{{--                <x-ui.icon name="bi-calendar-x"/>--}}
{{--                {{ __('pages/dashboard.alerts.no_events') }}--}}
{{--            </x-ui.alert>--}}
{{--        @endif--}}

{{--    </div>--}}
{{--</div>--}}
