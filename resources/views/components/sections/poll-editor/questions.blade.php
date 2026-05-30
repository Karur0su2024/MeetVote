<x-ui.card
    x-data="questionForm" @validation-failed.window="duplicateError($event.detail.errors)">
    <x-ui.text.title-lg>
        {{ __('pages/poll-editor.questions.title') }}
        <div class="tooltip" data-tip="{{ __('pages/poll-editor.questions.tooltip') }}">
            <x-mary-icon name="s-question-mark-circle" class="w-4 h-4" />
        </div>
    </x-ui.text.title-lg>


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
