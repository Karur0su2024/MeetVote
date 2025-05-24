<div class="card mb-3 shadow-sm bg-base-300 p-2"
     x-data="{ collapsed: false }">
    <div class="flex flex-row space-x-2 mb-2">
        <input type="text"
               class="input flex-1"
               x-model="questions[questionIndex].text"
               :placeholder="'{{ __('pages/poll-editor.questions.label.question') }} ' + (questionIndex + 1)"
            {{--               :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.text'] }"--}}
        />
        <button class="btn btn-outline btn-info"
                @click="collapsed = !collapsed">
            <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>
        </button>
        <button class="btn btn-outline btn-error"
                @click="removeQuestion(questionIndex)"
                type="button">
            <i class="bi bi-trash"></i>
        </button>
    </div>
    <div class="flex flex-col space-y-3" x-show="!collapsed" x-collapse>
        <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
            <x-pages.poll-editor.questions-new.option/>
            {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
        </template>
    </div>

    <button @click="addQuestionOption(questionIndex)"
            type="button"
            class="btn mt-3">
        {{ __('pages/poll-editor.questions.button.add_option') }}
    </button>

    <span
        class="text-danger ms-2"
        x-show="messages.errors['form.questions.' + questionIndex + '.options']"
        x-text="messages.errors['form.questions.' + questionIndex + '.options']">
    </span>

</div>
