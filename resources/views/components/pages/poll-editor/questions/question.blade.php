<div class="tw:card tw:mb-3 tw:shadow-sm tw:bg-base-200"
     x-data="{ collapsed: false }">
    <div class="tw:flex flex-md-nowrap align-items-center tw:gap-2 tw:px-2 tw:pt-2 tw:pb-1">

        {{-- Input pole pro text otázky --}}
        <input type="text" :id="'question_' + questionIndex"
               x-model="questions[questionIndex].text"
               class="tw:input tw:input-sm tw:grow"
               :placeholder="'{{ __('pages/poll-editor.questions.label.question') }} ' + (questionIndex + 1)"
               :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.text'] }">

        {{-- Tlačítko pro odstranění otázky --}}
{{--        <x-ui.button @click="collapsed = !collapsed"--}}
{{--                     color="outline-secondary"--}}
{{--                     size="sm">--}}
{{--            <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>--}}
{{--        </x-ui.button>--}}
        <button  @click="removeQuestion(questionIndex)"
                 class="tw:btn tw:btn-error tw:btn-sm">
            Delete <i class="bi bi-trash"></i>
        </button>
    </div>

    {{-- Možnosti odpovědí --}}
    <div class="card-body tw:p-2" x-show="!collapsed" x-collapse>
        <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
            <x-pages.poll-editor.questions.option/>
            {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
        </template>

        <button class="tw:btn tw:btn-primary tw:btn-soft tw:btn-sm"
                @click="addQuestionOption(questionIndex)"
        >
            {{ __('pages/poll-editor.questions.button.add_option') }}
        </button>

        {{-- Chybová hláška --}}

        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.questions.' + questionIndex + '.options']"
            x-text="messages.errors['form.questions.' + questionIndex + '.options']">
        </span>


    </div>
</div>
