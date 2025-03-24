<div>
    <x-ui.modal.header>
        {{ __('ui/modals.choose_final_options.title') }}
    </x-ui.modal.header>
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
