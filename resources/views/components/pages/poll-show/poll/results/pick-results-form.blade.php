@props([
    'results'
])

<div class="" x-data="{ results: @entangle('results') }">

    <form wire:submit.prevent="insertToEventModal" class="flex flex-col gap-1">
        <div class="card bg-base-100 shadow-sm p-3">
            <div class="flex flex-row justify-between">
                <h3 class="text-lg font-medium">
                    {{ __('pages/poll-show.results.sections.results.pick_from_results.title') }}
                </h3>

                <div class="tooltip" data-tip="{{ __('pages/poll-show.results.sections.results.pick_from_results.buttons.create_event.tooltip') }}">
                    <button class="btn btn-primary btn-outline btn-sm">
                        {{ __('pages/poll-show.results.sections.results.pick_from_results.buttons.create_event.label') }}
                    </button>
                </div>
            </div>

            <div>
                <p class="text-sm font-light mt-2">
                    {{ __('pages/poll-show.results.sections.results.pick_from_results.description') }}
                </p>
            </div>
        </div>




        <x-pages.poll-show.poll.section-card :title="__('pages/poll-show.results.sections.results.pick_from_results.section.time_options')">
            <x-slot:content>
                @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                    <div @click="results.timeOptions.selected = {{ $optionIndex }}">
                        <x-pages.poll-show.poll.option-card class="result-card-clickable"{{-- ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}"--}}>
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
                        </x-pages.poll-show.poll.option-card>
                    </div>
                @endforeach
            </x-slot:content>
        </x-pages.poll-show.poll.section-card>



        @foreach($results['questions'] as $questionIndex => $question)
            <x-pages.poll-show.poll.section-card :title="$question['text']" >
                <x-slot:content>
                    @foreach($question['options'] as $optionIndex => $option)
                        <div  class="w-full md:w-1/2 px-2"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.option-card  class="result-card-clickable"
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
                            </x-pages.poll-show.poll.option-card>
                        </div>
                    @endforeach
                </x-slot:content>
            </x-pages.poll-show.poll.section-card>
        @endforeach


    </form>
</div>
