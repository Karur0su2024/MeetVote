<div>
    <x-ui.card body-padding="0" collapsable>
        <x-slot:header>Results</x-slot:header>
        <x-slot:headerRight>
            <button class="btn btn-outline-secondary"
                    wire:click="openModal('modals.poll.results', '{{ $poll->id }}')">
                {{ __('pages/poll-show.voting.buttons.results') }} ({{ count($poll->votes) }})
            </button>
        </x-slot:headerRight>


        <!-- Časové možnosti -->
        <div class="p-4">

            <x-ui.alert type="warning">
                <x-ui.icon name="exclamation-triangle-fill"/>{{ __('pages/poll-show.voting.alert.poll_closed') }}
            </x-ui.alert>

            <h4 class="mb-3 mt-5
            ">Time options</h4>
            <div class="row g-3">
                @foreach($pollResults['timeOptions']['options'] as $option)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                                        <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                                    </div>
                                    <span class="badge bg-primary fs-5">{{ $option['score'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Otázky a jejich možnosti -->
        @foreach($pollResults['questions'] as $question)
            <div class="p-4">
                <h4 class="mb-3">{{ $question['text'] }}</h4>
                <div class="row g-3">
                    @foreach($question['options'] as $option)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>{{ $option['text'] }}</p>
                                        <span class="badge bg-primary">{{ $option['score'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </x-ui.card>
</div>
