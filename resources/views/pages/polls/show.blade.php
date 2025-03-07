@php
    $isAdmin = request()->get('isPollAdmin', false);
    //dd($isAdmin);
@endphp


<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        @if ($isAdmin)
            <div class="alert alert-secondary mb-3" role="alert">
                You are in admin mode!
            </div>
        @endif


        <!-- Panel s nastavením ankety -->
        <div class="card mb-3 p-2">
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
                            <li><a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">Edit poll</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openShareModal('{{ $poll->public_id }}')">Share poll</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openClosePollModal('{{ $poll->public_id }}')">Close poll</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openModal('modals.poll.choose-final-options', '{{ $poll->public_id }}')">Final options</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openModal('modals.poll.create-event', '{{ $poll->public_id }}')">Create event</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openInvitationsModal('{{ $poll->public_id }}')">
                                    Invitations</a></li>
                            <li><a class="dropdown-item" href="#" onclick="openDeletePollModal('{{ $poll->public_id }}')">Delete poll</a></li>

                        </ul>
                    </div>
                @endif
            </div>

        </div>

        <div class="card p-4 shadow-sm text-start mb-3">
            <h2>{{ $poll->title }}</h2>
            <div class="d-flex align-items-center text-muted mb-2">
                {{-- Doplnit logo autora --}}
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
        <livewire:poll.voting :poll="$poll" />







        {{-- Komentáře --}}


        @if ($poll->comments)
            <livewire:poll.comments :poll="$poll" />
        @endif


    </div>



</x-layouts.app>


<script>
    function openInvitationsModal(index) {
        console.log(index);
        Livewire.dispatch('showModal', {
            data: {
                alias: 'modals.invitations',
                params: {
                    publicIndex: index
                }
            },

        });
    }

    function openDeletePollModal(index) {
        console.log(index);
        Livewire.dispatch('showModal', {
            data: {
                alias: 'modals.delete-poll',
                params: {
                    publicIndex: index
                }
            },

        });
    }

    function openShareModal(index) {
        console.log(index);
        Livewire.dispatch('showModal', {
            data: {
                alias: 'modals.share',
                params: {
                    publicIndex: index
                }
            },

        });
    }

    function openClosePollModal(index) {
        console.log(index);
        Livewire.dispatch('showModal', {
            data: {
                alias: 'modals.poll.close-poll',
                params: {
                    publicIndex: index
                }
            },

        });
    }

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