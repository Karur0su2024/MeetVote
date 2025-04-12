{{--

TODO: Přidat souhrn výsledků sem, pomocí karet
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div>
    <p class="text-muted">You can see the results of the poll here.</p>
        <div class="card h-100 mb-3 poll-section-card">
            <div class="card-body">
                <h5>All votes</h5>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($votes as $vote)
                        <x-ui.button size="sm"
                                     color="outline-secondary"
                                     wire:click="openVoteModal({{ $vote }})">
                            {{ $poll->settings['anonymous_votes'] ? 'Anonymous' : $vote->voter_name }}
                        </x-ui.button>
                    @empty
                        No votes yet.
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
            Poll results are hidden by the poll creator.
        </x-ui.alert>
    @endcan

</div>
