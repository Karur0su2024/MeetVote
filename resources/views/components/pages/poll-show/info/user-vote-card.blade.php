<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/poll-show.your_vote.title') }}
    </x-slot:title>
    @can('delete', $userVote)
        <button class="tw-btn tw-btn-error tw-btn-sm tw-float-end"
                wire:click="deleteVote({{ $userVote->id }})">
            <i class="bi bi-trash"></i>
            {{ __('pages/poll-show.your_vote.buttons.delete') }}
        </button>
    @endcan

    @if($userVote && ($userVote->questionOptions->count() > 0 || $userVote->timeOptions->count() > 0))
        <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
        @cannot('edit', $userVote)

            <div class="mt-2">
                <p class="tw-text-md tw-font-light tw-color-gray-500">
                    {{ __('pages/poll-show.your_vote.text.login_to_change_vote') }}
                </p>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                    {{ __('pages/poll-show.your_vote.buttons.login') }}
                </a>
            </div>
        @endcannot
    @else
        <p class="tw-text-md tw-font-light tw-text-gray-500">
            {{ __('pages/poll-show.your_vote.no_vote') }}
        </p>
    @endif
</x-ui.tw-card>
