<div>
    <div class="modal-header">
        <h5 class="modal-title">Close Poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form wire:submit.prevent='chooseFinalResults'>
            <div class="accordion" id="chooseFinalResultsAccordion">
                <x-accordion-item-results-time-options :timeOptions="$timeOptions" :selected="$selected"/>
            @foreach ($questions as $questionIndex => $question)
                <x-accordion-item-results-question :questionIndex="$questionIndex" :question="$question" :selected="$selected"/>
            @endforeach
            <button type="submit" class="btn btn-primary mt-3">Insert to Calendar</button>
        </form>
    </div>
</div>
