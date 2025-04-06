@props([
    'results'
])

<div class="mt-4">

    <h3>
        Results
    </h3>

    <div>
        <h4 class="my-3">Time options</h4>
        <div class="row g-3">
            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div class="col-md-6">
                    <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                        <x-slot:content>
                            <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                            <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                            @foreach($option->preferences as $$preferenceName => $preference)
                                {{ $preferenceName }}
                            @endforeach
                        </x-slot:content>
                    </x-pages.poll-show.poll.results.option-card>
                </div>
            @endforeach
        </div>
    </div>


    @foreach($results['questions'] as $questionIndex => $question)
        <div class="my-3">
            <h4 class="mb-3">{{ $question['text'] }}</h4>
            <div class="row g-3">
                @foreach($question['options'] as $optionIndex => $option)
                    <div class="col-md-6">
                        <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                            <x-slot:content>
                                <p class="fs-5 fw-bold">{{ $option['text'] }}</p>
                            </x-slot:content>
                        </x-pages.poll-show.poll.results.option-card>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
