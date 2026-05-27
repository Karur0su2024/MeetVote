{{--

IDEA: Přidat nějaký hezčí souhrn výsledků
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div class="flex flex-col gap-1">
    <div class="card bg-base-100 poll-section-card p-3">
        <h5 class="text-lg font-medium mb-2">{{ __('pages/poll-show.results.sections.all_votes.title') }}</h5>
        <div class="flex gap-2">
            @forelse($votes as $vote)
                <button class="btn btn-sm btn-dash btn-outline"
                        @click="$wire.dispatch('openUserVoteModal', { voteId: {{ $vote->id }} })">
                    {{ ($poll->settings['anonymous_votes'] ?? false) ? __('pages/poll-show.results.sections.all_votes.anonymous') : (Auth::user()->name ?? $vote->voter_name) }}
                </button>
            @empty
                {{ __('pages/poll-show.results.sections.all_votes.empty') }}
            @endforelse

        </div>
    </div>



    @can('viewResults', $poll)

        @can('chooseResults', $poll)
            <x-pages.poll-show.poll.results.pick-results-form :results="$results"/>
        @else
            <x-pages.poll-show.poll.results.view-only :results="$results"/>
        @endcan

    @else
        <x-ui.alert type="warning">
            {{ __('pages/poll-show.results.alerts.hidden') }}
        </x-ui.alert>
    @endcan

</div>
