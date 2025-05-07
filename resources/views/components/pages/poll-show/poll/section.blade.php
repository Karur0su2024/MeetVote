@push('scripts')
    <script>
        Livewire.on('show-voting-section', () => {
            window.dispatchEvent(new CustomEvent('change-section'));
        });
    </script>
@endpush

<div x-data="{
    mode: '{{ Gate::allows('canVote', $poll) ? 'Voting' : 'Results' }}'
    }"
    @change-section.window="mode = 'Voting'">

    <x-ui.card header-hidden>

        <x-slot:body-header>
            <h2 x-text="mode === 'Voting' ? '{{ __('pages/poll-show.voting.title')}}' : '{{ __('pages/poll-show.results.title') }}'"></h2>
            <div>
                @can('canVote', $poll)
                    <x-ui.button color="outline-secondary"
                                 x-text="mode === 'Results' ?
                                 '{{ __('pages/poll-show.results.sections.results.buttons.show_voting_section') }}' :
                                 '{{ __('pages/poll-show.voting.buttons.show_result_section.label') }}'"
                                 @click="mode = mode === 'Results' ? 'Voting' : 'Results'">
                    </x-ui.button>

                @endcan
            </div>

        </x-slot:body-header>

        <x-slot:body>
            <div>


                @if($poll->isActive())
                    @if($poll->deadline)
                        <x-ui.alert type="info">
                          {{ __('pages/poll-show.voting.alert.deadline', ['now_poll_deadline' => (int) \Carbon\Carbon::parse($poll->deadline)->diffInDays(now(), $poll->deadline)]) }}
                        </x-ui.alert>
                    @endif
                    @can('canVote', $poll)
                            <div x-show="mode === 'Voting'">
                                <livewire:pages.poll-show.poll-section.voting :poll-index="$poll->id" />
                            </div>
                    @endcan
                @else
                    <x-ui.alert type="warning">
                        {{ __('pages/poll-show.results.alerts.ended') }}
                    </x-ui.alert>
                @endif
                <div x-show="mode === 'Results'">
                    <livewire:pages.poll-show.poll-section.results :poll="$poll" />
                </div>
            </div>
        </x-slot:body>
    </x-ui.card>

</div>
