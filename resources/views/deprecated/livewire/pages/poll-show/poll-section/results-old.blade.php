{{--

IDEA: Přidat nějaký hezčí souhrn výsledků
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div>
    {{--    <p class="text-base-600 font-light my-3">--}}
    {{--        {{ __('pages/poll-show.results.description') }}--}}
    {{--    </p>--}}
    <div class="card bg-base-300 my-3 poll-section-card ">
        <div class="card-body">
            <h5 class="text-lg font-medium mb-2">{{ __('pages/poll-show.results.sections.all_votes.title') }}</h5>
            <div class="flex gap-2">
                @forelse($votes as $vote)
                    <button class="btn btn-sm btn-dash btn-outline"
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
