<x-ui.card
    x-data="questionForm" @validation-failed.window="duplicateError($event.detail.errors)">
    <h3 class="text-lg font-semibold">
        {{ __('pages/poll-editor.questions.title') }}
        <div class="tooltip" data-tip="{{ __('pages/poll-editor.questions.tooltip') }}">
            <i class="bi bi-question-circle-fill text-sm"></i>
        </div>
    </h3>


    <template x-if="questions.length > 0">
        <template x-for="(question, questionIndex) in questions">
            {{-- Komponenta s jednou otázkou --}}
            <x-pages.poll-editor.questions.question/>

        </template>
    </template>

    <template x-if="questions.length == 0">
        <x-mary-alert class="alert-info alert-soft"
                      title="{{ __('pages/poll-editor.questions.alert.no_questions') }}"
        />
    </template>

    <x-mary-button label="{{ __('pages/poll-editor.questions.button.add_question') }}"
                   class="btn-soft btn-sm btn-primary"
                   type="button"
                   @click="addQuestion()" />
    {{-- Tlačítko pro přidání další otázky --}}

    @error('form.questions')
    <span class="text-error">{{ $message }}</span>
    @enderror

</x-ui.card>

@push('scripts')
    <script src="{{ asset('js/alpine/questions.js') }}"></script>
@endpush
