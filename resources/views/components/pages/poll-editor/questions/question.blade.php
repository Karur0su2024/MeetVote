<div class="card mb-3 shadow-sm"
     x-data="{ collapsed: false }">
    <div class="card-header d-flex justify-content-between align-items-center editor-card-header border-bottom-0 gap-2">

        {{-- Input pole pro text otázky --}}
        <input type="text" :id="'question_' + questionIndex"
               x-model="questions[questionIndex].text"
               class="form-control"
               :placeholder="'{{ __('pages/poll-editor.questions.label.question') }} ' + (questionIndex + 1)"
               :class="{ 'is-invalid': messages.errors['form.questions.' + questionIndex + '.text'] }">

        {{-- Tlačítko pro odstranění otázky --}}
        <x-ui.button @click="collapsed = !collapsed"
                     color="outline-secondary"
                     size="sm">
            <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>
        </x-ui.button>
        <x-ui.button @click="removeQuestion(questionIndex)"
                     color="danger"
                     size="sm">
            <i class="bi bi-trash"></i>
        </x-ui.button>
    </div>

    {{-- Možnosti odpovědí --}}
    <div class="card-body" x-show="!collapsed" x-collapse>
        <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
            <x-pages.poll-editor.questions.option/>
            {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
        </template>

        <x-ui.button @click="addQuestionOption(questionIndex)"
                     color="outline-secondary">
            {{ __('pages/poll-editor.questions.button.add_option') }}
        </x-ui.button>

        {{-- Chybová hláška --}}

        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.questions.' + questionIndex + '.options']"
            x-text="messages.errors['form.questions.' + questionIndex + '.options']">
        </span>


    </div>
</div>
