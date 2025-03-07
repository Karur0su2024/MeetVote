<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Close Poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
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
