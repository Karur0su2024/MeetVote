<div class="card">
    <div class="card-header">
        <h1>Choose your options</h1>
    </div>

    <div class="card-body">
        <form wire:submit.prevent='chooseFinalResults'>
            <ul class="list-group">
                @foreach ($timeOptions as $optionIndex => $option)
                    <x-poll.show.end-poll-item :option="$option" :optionIndex="$optionIndex" :selected="$selectedTimeOption" />
                @endforeach
            </ul>

            <button type="submit" class="btn btn-primary mt-3">Submit</button>


        </form>

    </div>



</div>
