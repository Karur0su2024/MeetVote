@props([
    'results'
])

<div class="mt-4" x-data="{ results: @entangle('results') }">

    <form wire:submit.prevent="insertToEventModal">
        <h3>
            Choose results
        </h3>

        <x-ui.button type="submit">
            <x-slot:tooltip>
                Open event creation modal and pre-fill it with picked results.
                Then you can share the event with your friends.
            </x-slot:tooltip>
            Create event
        </x-ui.button>


        <x-pages.poll-show.poll.results.results-section-card>
            <x-slot:header>
                Time options
            </x-slot:header>
            <x-slot:content>
                @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                    <div class="col-lg-6 col-md-12" @click="results.timeOptions.selected = {{ $optionIndex }}">
                        <x-pages.poll-show.poll.results.option-card ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}">
                            <x-slot:text>
                                {{ $option['date_formatted'] }}
                            </x-slot:text>
                            <x-slot:subtext>
                                {{ $option['full_content'] }}
                            </x-slot:subtext>

                            <x-slot:bottom>
                                <x-pages.poll-show.poll.results.preference-view :score="$option['score']" :preferences="$option['preferences']"/>
                            </x-slot:bottom>
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
                        <div class="col-lg-6 col-md-12"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.results.option-card :score="$option['score']"
                                                                        ::class="{'border-primary': results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}}">
                                <x-slot:text>
                                    {{ $option['text'] }}
                                </x-slot:text>
                                <x-slot:bottom>
                                    <x-pages.poll-show.poll.results.preference-view :score="$option['score']"/>
                                </x-slot:bottom>
                            </x-pages.poll-show.poll.results.option-card>
                        </div>
                    @endforeach
                </x-slot:content>
            </x-pages.poll-show.poll.results.results-section-card>
        @endforeach


    </form>
</div>
