<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        @if (count($votes) === 0)
            <x-ui.alert type="info"
                        class="mb-3">
                <x-ui.icon class="exclamation-triangle-fill me-2" />
                {{ __('ui/modals.results.alert.no_votes')}}
            </x-ui.alert>
        @else
            <div class="accordion" id="resultsAccordion">
                @foreach ($votes as $vote)
                    <x-poll.show.vote-card :vote="$vote" />
                @endforeach
            </div>
        @endif
    </div>
</div>
