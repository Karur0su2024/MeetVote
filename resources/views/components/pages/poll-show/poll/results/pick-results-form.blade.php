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


        <x-pages.poll-show.poll.results.results-section-card>
            <x-slot:header>
                Time options
            </x-slot:header>
            <x-slot:content>
                @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                    <div class="col-lg-3 col-md-6" @click="results.timeOptions.selected = {{ $optionIndex }}">
                        <x-pages.poll-show.poll.results.option-card :score="$option['score']"
                                                                    ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}">
                            <x-slot:content :text="$option['date_formatted']" subtext="{{ $option['full_content'] }}">
                                <x-pages.poll-show.poll.results.preference-view :preferences="$option['preferences']"/>
                            </x-slot:content>
                        </x-pages.poll-show.poll.results.option-card>
                    </div>
                @endforeach
            </x-slot:content>
        </x-pages.poll-show.poll.results.results-section-card>



        @foreach($results['questions'] as $questionIndex => $question)
            <x-pages.poll-show.poll.results.results-section-card>
                <x-slot:header>
                    {{ $question['text'] }}
                </x-slot:header>
                <x-slot:content>
                    @foreach($question['options'] as $optionIndex => $option)
                        <div class="col-lg-3 col-md-6"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.results.option-card :score="$option['score']"
                                                                        ::class="{'border-primary': results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}}">
                                <x-slot:content>
                                    <p class="fs-5 fw-bold">{{ $option['text'] }}</p>
                                </x-slot:content>
                            </x-pages.poll-show.poll.results.option-card>
                        </div>
                    @endforeach
                </x-slot:content>
            </x-pages.poll-show.poll.results.results-section-card>
        @endforeach


    </form>
</div>
