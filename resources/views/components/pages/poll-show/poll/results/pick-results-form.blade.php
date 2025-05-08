@props([
    'results'
])

<div class="mt-5" x-data="{ results: @entangle('results') }">

    <form wire:submit.prevent="insertToEventModal">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0">
                {{ __('pages/poll-show.results.sections.results.pick_from_results.title') }}
            </h3>

            <x-ui.button type="submit">
                <x-slot:tooltip>
                    {{ __('pages/poll-show.results.sections.results.pick_from_results.buttons.create_event.tooltip') }}
                </x-slot:tooltip>
                {{ __('pages/poll-show.results.sections.results.pick_from_results.buttons.create_event.label') }}
            </x-ui.button>
        </div>

        <p class="text-muted mt-2">
            {{ __('pages/poll-show.results.sections.results.pick_from_results.description') }}
        </p>


        <x-pages.poll-show.poll.results.results-section-card :title="__('pages/poll-show.results.sections.results.pick_from_results.section.time_options')">
            <x-slot:content>
                @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                    <div class="col-lg-6 col-md-12" @click="results.timeOptions.selected = {{ $optionIndex }}">
                        <x-pages.poll-show.poll.results.option-card class="result-card-clickable" ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}">
                            <x-slot:text>
                                {{ $option['date_formatted'] }}
                            </x-slot:text>
                            <x-slot:subtext>
                                {{ $option['full_content'] }}
                            </x-slot:subtext>
                            <x-slot:right>
                                <i x-show="results.timeOptions.selected === {{ $optionIndex }}" class="bi bi-check-circle-fill"></i>
                            </x-slot:right>

                            <x-slot:bottom>
                                <x-pages.poll-show.poll.results.preference-view :score="$option['score']" :preferences="$option['preferences']"/>
                            </x-slot:bottom>
                        </x-pages.poll-show.poll.results.option-card>
                    </div>
                @endforeach
            </x-slot:content>
        </x-pages.poll-show.poll.results.results-section-card>



        @foreach($results['questions'] as $questionIndex => $question)
            <x-pages.poll-show.poll.results.results-section-card :title="$question['text']" >
                <x-slot:content>
                    @foreach($question['options'] as $optionIndex => $option)
                        <div class="col-lg-6 col-md-12"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.results.option-card  class="result-card-clickable"
                                                                         ::class="{'border-primary': results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}}">
                                <x-slot:text>
                                    {{ $option['text'] }}
                                </x-slot:text>

                                <x-slot:right>
                                    <i x-show="results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}" class="bi bi-check-circle-fill"></i>
                                </x-slot:right>

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
