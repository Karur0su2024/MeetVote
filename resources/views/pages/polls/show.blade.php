<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        <div class="mb-5">
            @if ($isAdmin)
                <div class="alert alert-info shadow-sm" role="alert">
                    <i class="bi bi-info-circle me-1"></i> You are in admin mode!
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger shadow-sm" role="alert">
                    <i class="bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                </div>
            @endif
        </div>




        <!-- Tohle přesunout do samostatné komponenty -->
        <!-- Panel s nastavením ankety -->
        @if ($isAdmin)
            <x-poll.show.settings :poll="$poll" />
        @endif
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
                        @if ($poll->comments)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Comments</span>
                        @endif
                        @if ($poll->anonymous_votes)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Anonymous votes</span>
                        @endif
                        @if ($poll->password)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Password set</span>
                        @endif
                        @if ($poll->invite_only)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Invite only</span>
                        @endif
                        @if ($poll->edit_votes)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Can edit votes</span>
                        @endif
                        @if ($poll->add_time_options)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Participants can add options</span>
                        @endif
                        @if ($poll->deadline)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Ends in
                                {{ now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline)) }} days</span>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Pravá strana – informace o události --}}
            <livewire:poll.event-details :pollId="$poll->id" :isAdmin="$isAdmin" />

        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting :poll="$poll" />

        {{-- Komentáře --}}
        @if ($poll->comments)
            <livewire:poll.comments :poll="$poll" />
        @endif


    </div>

</x-layouts.app>
