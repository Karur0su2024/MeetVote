<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        @if ($votes)
            @if($poll->anonymous_votes)
                <x-ui.alert type="warning">
                    <x-ui.icon name="exclamation-triangle-fill"/>
                    {{ __('ui/modals.results.alert.anonymous_votes') }}
                </x-ui.alert>
            @endif

            <div class="accordion" id="resultsAccordion">
                @foreach ($votes as $voteIndex => $vote)
                    @can('view', $vote)
                        <x-poll.show.vote-card :vote="$vote" wire:key="{{$voteIndex}}"/>
                    @endcan
                @endforeach
            </div>
        @else
            <x-ui.alert type="info"
                        class="mb-3">
                <x-ui.icon class="exclamation-triangle-fill me-2"/>
                {{ __('ui/modals.results.alert.no_votes')}}
            </x-ui.alert>
        @endif
    </div>
</div>
