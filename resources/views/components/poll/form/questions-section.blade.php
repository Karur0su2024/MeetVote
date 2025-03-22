<x-card>
    <x-slot:header>{{ __('form.section.title.questions') }}</x-slot>
    <x-slot:tooltip>
        {{ __('form.section.tooltip.questions') }}
    </x-slot:tooltip>

    <template x-if="form.questions.length > 0">
        <template x-for="(question, questionIndex) in form.questions" :key="questionIndex">
            <x-poll.form.question-card>
                <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
                    <x-poll.form.question-card-option/>
                    {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
                </template>
            </x-poll.form.question-card>
        </template>
    </template>

    <template x-if="form.questions.length == 0">
        <x-alert>
            {{  __('form.alert.no_questions') }}
        </x-alert>
    </template>
    {{-- Tlačítko pro přidání další otázky --}}
    <button type="button"
            @click="addQuestion()"
            class="btn btn-outline-secondary w-25">{{ __('form.button.add_question') }}</button>

    @error('form.questions')
    <span
            class="text-danger ms-2">{{ $message }}</span>
    @enderror
</x-card>
