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
                    <x-pages.poll-show.poll.results.option-card>
                        <x-slot:content>
                            <x-slot:text>
                                {{ $option['date_formatted'] }}
                            </x-slot:text>
                            <x-slot:subtext>
                                {{ $option['full_content'] }}
                            </x-slot:subtext>
                        </x-slot:content>
                        <x-slot:bottom>
                            <x-pages.poll-show.poll.results.preference-view :score="$option['score']" :preferences="$option['preferences']"/>
                        </x-slot:bottom>
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
