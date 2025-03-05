<div class="card mb-3">
    <div class="card-header">
        <h1>Choose your options</h1>
    </div>

    <div class="card-body">
        <form wire:submit.prevent='chooseFinalResults'>
            <div class="mb-3">
                <h3>Dates</h3>
                <ul class="list-group">
                    @foreach ($timeOptions as $optionIndex => $option)
                        <x-poll.show.end-poll-item :option="$option" :optionIndex="$optionIndex" />
                    @endforeach
                </ul>
            </div>


            @foreach ($questions as $questionIndex => $question)
                <div class="mb-3">
                    <h3>{{ $question['text'] }}</h3>
                    <ul class="list-group">
                        @foreach ($question['options'] as $optionIndex => $option)
                            <x-poll.show.end-poll-item-question :option="$option" :questionIndex="$questionIndex" :optionIndex="$optionIndex" />
                        @endforeach

                    </ul>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Submit</button>


        </form>



    </div>



</div>
