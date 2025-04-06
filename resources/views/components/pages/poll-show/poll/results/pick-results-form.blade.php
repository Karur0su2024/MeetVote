@props([
    'results'
])

<div class="mt-4" x-data="{ results: @entangle('results') }">

    <form wire:submit.prevent="insertToEventModal">
    <h3>
        Choose results
    </h3>

    <x-ui.button type="submit" size="lg">
        Insert into event form
    </x-ui.button>

    <div>
        <h4 class="mt-2">Time options</h4>
        <div class="row g-3">
            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div class="col-md-6" @click="results.timeOptions.selected = {{ $optionIndex }}">
                    <x-pages.poll-show.poll.results.option-card ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}">
                        <x-slot:content>
                            <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                            <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                        </x-slot:content>
                        <x-slot:score>
                            <span class="badge bg-primary fs-5">{{ $option['score'] }}</span>
                        </x-slot:score>
                    </x-pages.poll-show.poll.results.option-card>
                </div>
            @endforeach
        </div>
    </div>


        @foreach($results['questions'] as $questionIndex => $question)
            <div class="mt-3" x-data="{ selected: null }" x-init="selected = results.questions[{{ $questionIndex}}].selected">
                <h4 class="mb-3">{{ $question['text'] }}</h4>
                <div class="row g-3">
                    @foreach($question['options'] as $optionIndex => $option)
                        <div class="col-md-6"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.results.option-card
                                ::class="{'border-primary': results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}}">
                                <x-slot:content>
                                    <p>{{ $option['text'] }}</p>
                                </x-slot:content>
                                <x-slot:score>
                                    <span class="badge bg-primary">{{ $option['score'] }}</span>
                                </x-slot:score>
                            </x-pages.poll-show.poll.results.option-card>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach


    </form>
</div>
