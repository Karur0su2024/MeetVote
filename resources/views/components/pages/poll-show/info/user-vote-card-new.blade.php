<div class="card bg-base-100 shadow-sm p-4">
    <div class="flex flex-row">
        <h3 class="text-lg flex-1">
            {{ __('pages/poll-show.your_vote.title') }}
        </h3>
        @can('delete', $userVote)
        <button wire:click="deleteVote({{ $userVote->id }})"
                class="btn btn-error btn-sm btn-soft">
            <x-ui.icon name="trash"/>
            {{ __('pages/poll-show.your_vote.buttons.delete') }}
        </button>
        @endcan
    </div>

    @if($userVote && ($userVote->questionOptions->count() > 0 || $userVote->timeOptions->count() > 0))
        <x-pages.poll-show.poll.results.vote-content-new :vote="$userVote"/>
        @cannot('edit', $userVote)

            <div class="mt-2">
                <p class="text-muted">
                    {{ __('pages/poll-show.your_vote.text.login_to_change_vote') }}
                </p>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                    {{ __('pages/poll-show.your_vote.buttons.login') }}
                </a>
            </div>
        @endcannot
    @else
        <p class="text-muted mt-2">
            {{ __('pages/poll-show.your_vote.no_vote') }}
        </p>
    @endif
</div>
