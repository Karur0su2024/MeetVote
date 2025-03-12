<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        @if ($isAdmin)
            <div class="alert alert-secondary mb-3 shadow-sm" role="alert">
                You are in admin mode!
            </div>
        @endif


        <!-- Tohle přesunout do samostatné komponenty -->
        <!-- Panel s nastavením ankety -->
        <div class="card mb-5 p-2 shadow-sm">
            <div class="d-flex justify-content-end gap-2">
                <a href="#" class="btn btn-outline-secondary">
                    Notifications </a>
                @if ($isAdmin)
                    {{-- Dropdown pro správce --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </button>
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item py-1" href="{{ route('polls.edit', $poll) }}">
                                    <i class="bi bi-pencil-square"></i> Edit poll
                                </a>
                            </li>

                            <x-poll.show.dropdown-item modalName="share" :id="$poll->public_id">
                                <i class="bi bi-share"></i> Share poll
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="close-poll" :id="$poll->id">
                                <i class="bi bi-x-circle"></i> Close poll
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="choose-final-options" :id="$poll->id">
                                <i class="bi bi-check2-square"></i> Final options
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="create-event" :id="$poll->id">
                                <i class="bi bi-calendar-event"></i> Create event
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="invitations" :id="$poll->id">
                                <i class="bi bi-person-plus"></i> Invitations
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="delete-poll" :id="$poll->id" type="danger">
                                <i class="bi bi-trash"></i> Delete poll
                            </x-poll.show.dropdown-item>

                        </ul>
                    </div>
                @endif
            </div>

        </div>

        {{-- Základní informace o anketě --}}


        <div class="row g-4 mb-5">
            {{-- Levá strana – základní informace o anketě --}}
            <div class="col-lg-8 d-flex">
                <div class="card shadow-sm text-start mb-5 w-100 h-100 border-0">
                    <div class="card-body">
                        <h2>{{ $poll->title }}</h2>
                        <div class="d-flex align-items-center text-muted mb-2">
                            {{-- Doplnit avatar uživatele --}}
                            <span>{{ $poll->author_name }}</span>
                        </div>
                        <p class="card-text text-muted">
                            {{ $poll->description }}
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
                        @if ($poll->deadline)
                            <span class="badge text-bg-secondary border-1 shadow-sm">Ends in
                                {{ now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline)) }} days</span>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Pravá strana – informace o události --}}
            <livewire:poll.event-details :pollId="$poll->id" />

        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting :poll="$poll" />

        {{-- Komentáře --}}
        @if ($poll->comments)
            <livewire:poll.comments :poll="$poll" />
        @endif


    </div>



</x-layouts.app>


<script>
    function openModal(alias, index) {
        console.log(index);
        Livewire.dispatch('showModal', {
            data: {
                alias: alias,
                params: {
                    publicIndex: index
                }
            },

        });
    }
</script>
