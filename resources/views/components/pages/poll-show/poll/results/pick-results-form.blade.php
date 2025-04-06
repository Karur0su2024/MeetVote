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
        <h4 class="my-4">Time options</h4>
        <div class="row g-3">
            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div class="col-md-6" @click="results.timeOptions.selected = {{ $optionIndex }}">
                    <x-pages.poll-show.poll.results.option-card :score="$option['score']"
                                                                ::class="{'border-primary': results.timeOptions.selected == {{ $optionIndex }}}">
                        <x-slot:content>
                            <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                            <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                            @foreach($option['preferences'] as $preferenceName => $preference)
                                <img src="{{ asset('icons/' . $preferenceName . '.svg') }}" alt="{{ $preferenceName  }}"
                                     data-bs-toggle="tooltip" data-bs-placement="top"
                                     data-bs-html="true"
                                     data-bs-title="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
                                {{ count($preference) }}
                            @endforeach
                        </x-slot:content>
                    </x-pages.poll-show.poll.results.option-card>
                </div>
            @endforeach
        </div>
    </div>


        @foreach($results['questions'] as $questionIndex => $question)
            <div class="mt-3">
                <h4 class="mb-3">{{ $question['text'] }}</h4>
                <div class="row g-3">
                    @foreach($question['options'] as $optionIndex => $option)
                        <div class="col-md-6"
                             @click="results.questions[{{ $questionIndex}}].selected = {{ $optionIndex }}">
                            <x-pages.poll-show.poll.results.option-card :score="$option['score']"
                                                                        ::class="{'border-primary': results.questions[{{ $questionIndex}}].selected === {{ $optionIndex }}}">
                                <x-slot:content>
                                    <p class="fs-5 fw-bold">{{ $option['text'] }}</p>
                                </x-slot:content>
                            </x-pages.poll-show.poll.results.option-card>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach


    </form>
</div>
