<div class="flex flex-row gap-2 mb-3 border"
     :class="{ 'existing-option': option.id }">
    <input type="text"
           :id="'question_' + questionIndex + '_option_' + optionIndex"
           x-model="questions[questionIndex].options[optionIndex].text"
           :placeholder="'{{ __('pages/poll-editor.questions.label.option') }} ' + (optionIndex + 1)"
           class="input input-sm flex-1"
           required
           :disabled="option.score > 0"
           :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.options.' + [optionIndex] + '.text'] }" />
    <button class="btn btn-outline btn-error btn-sm"
            @click="removeQuestionOption(questionIndex, optionIndex)"
            :class="{ 'disabled': questions[questionIndex].options.length <= 2 }">
        <i      :class="{ 'bi bi-exclamation-triangle': option.score > 0, 'bi bi-trash': !option.score }">
        </i>
    </button>
</div>
