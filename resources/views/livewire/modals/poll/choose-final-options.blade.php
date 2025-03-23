<div>
    <div class="modal-header">
        <h5 class="modal-title">{{ __('ui/modals.choose_final_options.title') }}</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <p class="text-muted">
            {{ __('ui/modals.choose_final_options.description') }}
        </p>
        <form wire:submit.prevent='chooseFinalResults'>
            <div class="accordion" id="chooseFinalResultsAccordion">
                <x-accordion-item-results-time-options :timeOptions="$timeOptions" :selected="$selected"/>
            @foreach ($questions as $questionIndex => $question)
                <x-accordion-item-results-question :questionIndex="$questionIndex" :question="$question" :selected="$selected"/>
            @endforeach
            <x-ui.button type="submit" class="btn btn-primary mt-3">
                {{ __('ui/modals.choose_final_options.buttons.insert_to_calendar') }}
            </x-ui.button>
        </form>
    </div>
</div>
