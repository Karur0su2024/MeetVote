@props([
    'results'
])


<div class="mt-4 border-top">

    <h4 class="my-3">
        Results
    </h4>

    <x-pages.poll-show.poll.results.results-section-card>
        <x-slot:header>
            Time options
        </x-slot:header>
        <x-slot:content>
            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div class="col-md-12 col-lg-6">
                    <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                        <x-slot:content :text="$option['date_formatted']" :subtext="$option['full_content']">
                            <x-pages.poll-show.poll.results.preference-view :preferences="$option['preferences']"/>
                        </x-slot:content>
                    </x-pages.poll-show.poll.results.option-card>
                </div>
            @endforeach
        </x-slot:content>
    </x-pages.poll-show.poll.results.results-section-card>

    @foreach($results['questions'] as $question)
        <x-pages.poll-show.poll.results.results-section-card>
            <x-slot:header>
                {{ $question['text'] }}
            </x-slot:header>
            <x-slot:content>
                @foreach($question['options'] as $option)
                    <div class="col-md-12 col-lg-6">
                        <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                            <x-slot:content>
                                {{ $option['text'] }}
                            </x-slot:content>
                        </x-pages.poll-show.poll.results.option-card>
                    </div>
                @endforeach
            </x-slot:content>
        </x-pages.poll-show.poll.results.results-section-card>
    @endforeach

</div>
