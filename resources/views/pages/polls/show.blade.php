@php
    $isAdmin = request()->get('isPollAdmin', false);
    //dd($isAdmin);
@endphp


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
        <div class="card mb-3 p-2 shadow-sm">
            <div class="d-flex justify-content-end gap-2">
                <a href="#" class="btn btn-outline-secondary">Copy link</a>
                @if (request()->get('isPollAdmin', false))
                    {{-- Dropdown pro správce --}}

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Options
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">
                                    <i class="bi bi-pencil-square"></i> Edit poll
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="openModal('modals.poll.share', '{{ $poll->public_id }}')">
                                    <i class="bi bi-share"></i> Share poll
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="openModal('modals.poll.close-poll', '{{ $poll->public_id }}')">
                                    <i class="bi bi-x-circle"></i> Close poll
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="openModal('modals.poll.choose-final-options', '{{ $poll->public_id }}')">
                                    <i class="bi bi-check2-square"></i> Final options
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="openModal('modals.poll.create-event', '{{ $poll->public_id }}')">
                                    <i class="bi bi-calendar-event"></i> Create event
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    onclick="openModal('modals.poll.invitations', '{{ $poll->public_id }}')">
                                    <i class="bi bi-person-plus"></i> Invitations
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                    onclick="openModal('modals.poll.delete-poll', '{{ $poll->public_id }}')">
                                    <i class="bi bi-trash"></i> Delete poll
                                </a>
                            </li>
                        </ul>

                    </div>
                @endif
            </div>

        </div>

        <div class="card p-4 shadow-sm text-start mb-3">
            <h2>{{ $poll->title }}</h2>
            <div class="d-flex align-items-center text-muted mb-2">
                {{-- Doplnit avatar uživatele --}}
                <span>{{ $poll->author_name }}</span>
            </div>

            <p class="mb-3">
                {{ $poll->description ?? 'No description' }}
            </p>


            {{-- Badges ankety --}}
            <div class="d-flex gap-2">
                @if ($poll->comments)
                    <span class="badge bg-secondary">Comments</span>
                @endif
                @if ($poll->anonymous_votes)
                    <span class="badge bg-secondary">Anonymous votes</span>
                @endif
                @if ($poll->password)
                    <span class="badge bg-secondary">Password set</span>
                @endif
                @if ($poll->invite_only)
                    <span class="badge bg-secondary">Invite only</span>
                @endif
                @if ($poll->deadline)
                    <span class="badge bg-secondary">Ends in
                        {{ now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline)) }} days</span>
                @endif

            </div>
        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting2 :poll="$poll" />





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
