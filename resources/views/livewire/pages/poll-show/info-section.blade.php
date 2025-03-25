@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="row g-4 mb-4" x-data="{ showEventDetails: true }">

    {{-- Levá strana – základní informace o anketě --}}
    <div :class="{ 'col-lg-8': showEventDetails, 'col-lg-12': !showEventDetails }">
        <x-ui.card class="w-100 h-100"
                   header-hidden
                   footer-flex>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>{{ $poll->title }}</h2>
                <x-ui.button color="outline-secondary"
                             x-bind:class="showEventDetails ? 'active' : ''"
                             @click="showEventDetails = !showEventDetails">
                    <i class="bi bi-calendar"></i>
                </x-ui.button>
            </div>

            <div class="d-flex align-items-center text-muted mb-2">
                {{-- Doplnit avatar uživatele --}}
                <span>{{ $poll->author_name }}</span>
            </div>
            <p class="text-muted">
                @if ($poll->description == null || $poll->description == '')
                    {{ __('pages/poll-show.info.text.no_description') }}
                @else
                    {{ $poll->description }}
                @endif
            </p>
            <x-slot:footer>
                <x-badge>
                    {{ __('pages/poll-show.info.badges.status.' . $poll->status) }}
                </x-badge>
                @if ($poll->comments)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.comments') }}
                    </x-badge>
                @endif
                @if ($poll->anonymous_votes)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.anonymous_voting') }}
                    </x-badge>
                @endif
                @if ($poll->password)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.password_protected') }}
                    </x-badge>
                @endif
                @if ($poll->invite_only)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.invite_only') }}
                    </x-badge>
                @endif
                @if ($poll->edit_votes)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.edit_votes') }}
                    </x-badge>
                @endif
                @if ($poll->add_time_options)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.add_time_options') }}
                    </x-badge>
                @endif
                @if ($poll->deadline)
                    <x-badge>
                        {{ __('pages/poll-show.info.badges.deadline_in', ['parse_poll_deadline' => now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline))]) }}
                    </x-badge>
                @endif
            </x-slot:footer>
        </x-ui.card>>
    </div>

    {{--Pravá strana – informace o události--}}
    <div class="col-lg-4"
         x-show="showEventDetails">
        <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" :isAdmin="$isAdmin"/>
    </div>
</div>
