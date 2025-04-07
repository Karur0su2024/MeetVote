@props([
    'results'
])


<div class="mt-4 border-top" >

    <h4 class="my-3">
        Results
    </h4>

    <div class="card">

        <div class="card-body">
            <h5 class="mb-3 text-muted">Time options</h5>
            <div class="row g-3">

            @foreach($results['timeOptions']['options'] as $optionIndex => $option)
                <div class="col-md-6 col-lg-3">
                    <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                        <x-slot:content>
                            <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                            <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                            <x-pages.poll-show.poll.results.preference-view :preferences="$option['preferences']"/>
                        </x-slot:content>
                    </x-pages.poll-show.poll.results.option-card>
                </div>
            @endforeach
        </div>
    </div>

        <x-pages.poll-show.poll.results.results-section-card>
            <x-slot:header>

            </x-slot:header>
            <x-slot:content>

            </x-slot:content>
        </x-pages.poll-show.poll.results.results-section-card>



        @foreach($results['timeOptions']['options'] as $optionIndex => $option)
            <div class="col-md-6 col-lg-3">
                <x-pages.poll-show.poll.results.option-card :score="$option['score']">
                    <x-slot:content>
                        <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                        <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                        <x-pages.poll-show.poll.results.preference-view :preferences="$option['preferences']"/>
                    </x-slot:content>
                </x-pages.poll-show.poll.results.option-card>
            </div>
        @endforeach


    @foreach($results['questions'] as $questionIndex => $question)
        <div class="my-3">
            <h4 class="mb-3">{{ $question['text'] }}</h4>
            <div class="row g-3">
                @foreach($question['options'] as $optionIndex => $option)
                    <div class="col-md-4">
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
</div>
