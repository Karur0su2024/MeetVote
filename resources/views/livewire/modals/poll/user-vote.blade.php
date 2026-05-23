{{-- Modální okno s konkrétní odpovedí --}}
<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ ($vote->poll->settings['anonymous_votes'] ?? false) ? 'Anonymous' : (Auth::user()->name ?? $vote->voter_name) }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif

        </div>
        <div class="tw:badge tw:badge-outline tw:badge-sm tw:badge-primary">
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </div>
        @if(session()->has('poll.' . $vote->poll->id .'.vote'))
            @cannot('edit', $vote)

                <div class="tw:mt-2">
                    <p class="tw:mb-1">
                        You can change your vote only if you are logged in.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn">
                        {{ __('pages/poll-show.your_vote.buttons.login') }}
                    </a>
                </div>
            @endcannot
        @endif

        <div class="tw:mt-1">
            {{ $vote->message ?? '' }}
        </div>


        @can('delete', $vote)
            <div class="tw:mt-3">
                <x-ui.tw-button color="error" wire:click="deleteVote({{$vote->id}})">
                    <x-ui.icon name="trash" /> Delete
                </x-ui.tw-button>
            </div>
        @endcan

        <x-pages.poll-show.poll.results.vote-content :vote="$vote"/>
    </div>
</div>
