<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        <div class="mb-3 alerts-container">
            @if (session('error'))
                <x-ui.alert type="danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </x-ui.alert>
            @endif
            @if (session('success'))
                <x-ui.alert type="success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </x-ui.alert>
            @endif
        </div>




        @can('isAdmin', $poll)
            {{-- Panel s nastavením ankety --}}
            <livewire:pages.poll-show.settings-section :pollId="$poll->id"  />
        @endcan

        {{-- Základní informace o anketě --}}
        <div class="row g-4 mb-4">
            {{-- Levá strana – základní informace o anketě --}}
            <div class="col-lg-8 d-flex">
                <div class="card  shadow text-start mb-5 w-100 h-100 border-0">
                    <div class="card-body">
                        <h2>{{ $poll->title }}</h2>
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
                            <x-badge>Ends in{{ now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline)) }} days</x-badge>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Pravá strana – informace o události --}}
{{--            <livewire:poll.event-details :pollId="$poll->id" :isAdmin="$isAdmin"/>--}}

        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting :poll-id="$poll->id"/>

        {{-- Komentáře --}}
        @if ($poll->comments)
            <livewire:poll.comments :poll="$poll"/>
        @endif

    </div>

</x-layout.app>

