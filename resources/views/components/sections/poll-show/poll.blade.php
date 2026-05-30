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

    <div class="flex flex-col gap-1">
        <div class="card shadow-sm p-3 bg-base-100 flex flex-row justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold"
                    x-text="mode === 'Voting' ? '{{ __('pages/poll-show.voting.title')}}' : '{{ __('pages/poll-show.results.title') }}'"></h3>
            </div>
            <div class="shrink">
                @can('canVote', $poll)
                    <button class="btn btn-primary btn-sm"
                            x-text="mode === 'Results' ?
                                 '{{ __('pages/poll-show.results.sections.results.buttons.show_voting_section') }}' :
                                 '{{ __('pages/poll-show.voting.buttons.show_result_section.label') }}'"
                            @click="mode = mode === 'Results' ? 'Voting' : 'Results'">
                    </button>
                @endcan
            </div>
        </div>
        <div class="card bg-base-100 flex flex-row p-2 gap-3 items-center shadow-sm" x-show="mode === 'Voting'">
            <div class="flex justify-center gap-3 w-full">
                <x-sections.poll-show.voting.legend name="yes" value="2"/>
                <x-sections.poll-show.voting.legend name="maybe" value="1"/>
                <x-sections.poll-show.voting.legend name="no" value="-1"/>
            </div>
        </div>

        @if($poll->isActive())
            @if($poll->deadline)
                <div class="alert alert-info alert-soft">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    <span>{{ __('pages/poll-show.voting.alert.deadline', ['now_poll_deadline' => (int) \Carbon\Carbon::parse($poll->deadline)->diffInDays(now(), $poll->deadline)]) }}</span>
                </div>
            @endif
            @can('canVote', $poll)
                <div x-show="mode === 'Voting'">
                    {{--                    <livewire:pages.poll-show.poll-section.voting :poll-index="$poll->id" />--}}
                    <livewire:sections.poll-show.voting :poll-index="$poll->id"/>
                </div>
            @endcan
        @else
            <x-mary-alert title="{{ __('pages/poll-show.results.alerts.ended') }}"
                          class="alert-info alert-soft"
                          icon="o-information-circle"/>
        @endif
        <div x-show="mode === 'Results'">
            <livewire:sections.poll-show.results :poll="$poll"/>
        </div>
    </div>


</div>
