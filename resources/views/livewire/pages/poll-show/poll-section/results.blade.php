{{--

IDEA: Přidat nějaký hezčí souhrn výsledků
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div>
    <p class="tw-text-base-600 tw-font-light tw-mb-3">
        {{ __('pages/poll-show.results.description') }}
    </p>
        <div class="tw-card tw-bg-base-300 h-100 mb-3 poll-section-card tw-p-4">
            <div class="card-body">
                <h5 class="tw-text-lg tw-font-medium tw-mb-2">{{ __('pages/poll-show.results.sections.all_votes.title') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    @forelse($votes as $vote)
                        <button class="tw-btn tw-btn-sm tw-btn-dash tw-btn-outline"
                                wire:click="openVoteModal({{ $vote }})">
                            {{ ($poll->settings['anonymous_votes'] ?? false) ? __('pages/poll-show.results.sections.all_votes.anonymous') : (Auth::user()->name ?? $vote->voter_name) }}
                        </button>
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
