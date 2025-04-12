<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ $vote->poll->settings['anonymous_votes'] ? 'Anonymous' : $vote->voter_name }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif
        </div>
        <x-ui.pill>
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </x-ui.pill>

        <div class="text-muted mt-1">
            {{ $vote->message ?? '' }}
        </div>


        @can('delete', $vote)
            <div class="mt-3">
                <x-ui.button color="outline-danger" wire:click="deleteVote({{$vote->id}})">
                    <x-ui.icon name="trash" /> Delete
                </x-ui.button>
            </div>
        @endcan

        <x-pages.poll-show.poll.results.vote-content :vote="$vote"/>
    </div>
</div>
