<div class="row g-4 mb-4" x-data="{ showEventDetails: true }">

    {{-- Levá strana – základní informace o anketě --}}
    <div :class="{ 'col-lg-8': showEventDetails, 'col-lg-12': !showEventDetails }">
        <div class="card shadow text-start mb-5 w-100 h-100 border-0">
            <div class="card-body">
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
                        No description.
                    @else
                        {{ $poll->description }}
                    @endif
                </p>
            </div>
            <div class="card-footer">
                <x-badge>Open poll</x-badge>
                @if ($poll->comments)
                    <x-badge>Comments</x-badge>
                @endif
                @if ($poll->anonymous_votes)
                    <x-badge>Anonymous voting</x-badge>
                @endif
                @if ($poll->password)
                    <x-badge>Password set</x-badge>
                @endif
                @if ($poll->invite_only)
                    <x-badge>Invite only</x-badge>
                @endif
                @if ($poll->edit_votes)
                    <x-badge>Participants can edit votes</x-badge>
                @endif
                @if ($poll->add_time_options)
                    <x-badge>Participants can add time options</x-badge>
                @endif
                @if ($poll->deadline)
                    <x-badge>Ends in{{ now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline)) }}
                        days
                    </x-badge>
                @endif
            </div>

        </div>
    </div>

    {{--Pravá strana – informace o události--}}
    <div class="col-lg-4"
         x-show="showEventDetails">
        <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" :isAdmin="$isAdmin"/>
    </div>
</div>
