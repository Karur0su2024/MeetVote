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
            @if ($poll->status == 'closed')
                <div class="alert alert-danger shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Poll is closed!
                </div>
            @endif
        </div>




        <!-- Tohle přesunout do samostatné komponenty -->
        <!-- Panel s nastavením ankety -->
        @if ($isAdmin)
            <div class="card mb-5 p-2 shadow-sm">
                <div class="d-flex justify-content-end gap-2">
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-bell-fill me-1"></i> Notifications </a>

                    {{-- Dropdown pro správce --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                        </button>
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item py-1" href="{{ route('polls.edit', $poll) }}">
                                    <i class="bi bi-pencil-square me-1"></i> Edit poll
                                </a>
                            </li>

                            <x-poll.show.dropdown-item modalName="share" :id="$poll->public_id">
                                <i class="bi bi-share me-1"></i> Share poll
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="close-poll" :id="$poll->public_id">
                                @if ($poll->status == 'active')
                                    <i class="bi bi-lock me-1"></i> Close poll
                                @else
                                    <i class="bi bi-unlock me-1"></i> Reopen poll
                                @endif
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="invitations" :id="$poll->public_id">
                                <i class="bi bi-person-plus me-1"></i> Invitations
                            </x-poll.show.dropdown-item>

                            <x-poll.show.dropdown-item modalName="delete-poll" :id="$poll->id" type="danger">
                                <i class="bi bi-trash me-1"></i> Delete poll
                            </x-poll.show.dropdown-item>

                        </ul>
                    </div>

                </div>

            </div>
        @endif
        {{-- Základní informace o anketě --}}


        <div class="row g-4 mb-5">
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
