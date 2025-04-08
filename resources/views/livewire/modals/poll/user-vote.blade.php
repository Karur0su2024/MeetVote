<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ $vote->poll->anonymous_votes ? 'Anonymous' : $vote->voter_name }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif
        </div>
        <x-ui.pill>
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </x-ui.pill>

        <div class="text-muted small mt-1">
            {{ $vote->message }}
        </div>


        <x-pages.poll-show.poll.results.vote-content :vote="$vote"/>
    </div>
</div>
