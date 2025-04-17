<div class="d-flex align-items-center gap-2 mb-3 p-2 mb-2 rounded border"
     :class="{ 'existing-option': option.id }">

    {{-- Input pole pro text možnosti --}}
    <input type="text"
           :id="'question_' + questionIndex + '_option_' + optionIndex"
           x-model="questions[questionIndex].options[optionIndex].text"
           :placeholder="'{{ __('pages/poll-editor.questions.label.option') }} ' + (optionIndex + 1)"
           class="form-control"
           required
           :disabled="option.score > 0"
           :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.options.' + [optionIndex] + '.text'] }"
    >

    {{-- Tlačítko pro odstranění možnosti --}}
    <x-ui.button @click="removeQuestionOption(questionIndex, optionIndex)"
                 ::class="{ 'disabled': questions[questionIndex].options.length <= 2 }"
                 color="danger">
        <i      :class="{ 'bi bi-exclamation-triangle': option.score > 0, 'bi bi-trash': !option.score }">
        </i>
    </x-ui.button>

</div>
