<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ $vote->voter_name ?? 'anonymous' }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif
        </div>
        <div class="text-muted small">
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </div>


        <div class="text-muted small">
            {{ $vote->message }}
        </div>


        <x-pages.poll-show.poll.results.vote-content :vote="$vote"/>
    </div>
</div>
