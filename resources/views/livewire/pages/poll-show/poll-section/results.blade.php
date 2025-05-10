{{--

IDEA: Přidat nějaký hezčí souhrn výsledků
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div>
    <p class="text-muted">{{ __('pages/poll-show.results.description') }}</p>
        <div class="card h-100 mb-3 poll-section-card">
            <div class="card-body">
                <h5>{{ __('pages/poll-show.results.sections.all_votes.title') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($votes as $vote)
                        <x-ui.button size="sm"
                                     color="outline-secondary"
                                     wire:click="openVoteModal({{ $vote }})">
                            {{ ($poll->settings['anonymous_votes'] ?? false) ? __('pages/poll-show.results.sections.all_votes.anonymous') : (Auth::user()->name ?? $vote->voter_name) }}
                        </x-ui.button>
                    @empty
                        {{ __('pages/poll-show.results.sections.all_votes.empty') }}
                    @endforelse
                </div>
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
