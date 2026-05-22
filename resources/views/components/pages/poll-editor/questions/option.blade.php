<div class="tw:flex flex-md-nowrap align-items-center gap-2 tw:pb-2 rounded"
     :class="{ 'existing-option': option.id }">

    {{-- Input pole pro text možnosti --}}
    <input type="text"
           :id="'question_' + questionIndex + '_option_' + optionIndex"
           x-model="questions[questionIndex].options[optionIndex].text"
           :placeholder="'{{ __('pages/poll-editor.questions.label.option') }} ' + (optionIndex + 1)"
           class="tw:input tw:input-sm tw:grow"
           required
           :disabled="option.score > 0"
           :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.options.' + [optionIndex] + '.text'] }"
    >

    {{-- Tlačítko pro odstranění možnosti --}}
{{--    <x-ui.button @click="removeQuestionOption(questionIndex, optionIndex)"--}}
{{--                 ::class="{ 'disabled': questions[questionIndex].options.length <= 2 }"--}}
{{--                 color="danger">--}}
{{--        <i      :class="{ 'bi bi-exclamation-triangle': option.score > 0, 'bi bi-trash': !option.score }">--}}
{{--        </i>--}}
{{--    </x-ui.button>--}}

    <button  class="tw:btn tw:btn-sm tw:btn-outline tw:btn-error"
             ::class="{ 'disabled': questions[questionIndex].options.length <= 2 }"
             color="danger">
        <i      :class="{ 'bi bi-exclamation-triangle': option.score > 0, 'bi bi-trash': !option.score }">
        </i>
    </button>

</div>
