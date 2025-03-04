<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-center">

        <!-- Panel s nastavením ankety -->
        <div class="card mb-5 p-2">
            <div class="d-flex justify-content-end gap-2">
                <a href="#" class="btn btn-outline-secondary">Copy link</a>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Options
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">Edit poll</a></li>
                        <li><a class="dropdown-item" href="#">Share poll</a></li>
                        <li><a class="dropdown-item" href="#">Close poll</a></li>
                        <li><a class="dropdown-item" href="#">Invitations</a></li>
                        <li><a class="dropdown-item" href="#">Delete poll</a></li>


                    </ul>
                </div>
            </div>

        </div>

        <div class="card p-4 shadow-sm text-start mb-5">
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

        {{-- Všechny hlasy --}}
        <livewire:poll.all-votes :poll="$poll" />

        {{-- Komentáře --}}


        @if ($poll->comments)
            <livewire:poll.comments :poll="$poll" />
        @endif


    </div>



</x-layouts.app>
