<div x-data="questionForm" x-init="questions = form.questions">
    {{-- Základní informace o anketě --}}
<x-ui.card collapsable>
    <x-slot:header>{{ __('pages/poll-editor.questions.title') }}</x-slot>
    <x-slot:tooltip>
        {{ __('pages/poll-editor.questions.tooltip') }}
    </x-slot:tooltip>

    <template x-if="questions.length > 0">
        <template x-for="(question, questionIndex) in questions">
            {{-- Základní informace o anketě --}}
            <x-poll.form.question-card/>
        </template>
    </template>

    <template x-if="questions.length == 0">
        <x-ui.alert>
            {{ __('pages/poll-editor.questions.alert.no_questions') }}
        </x-ui.alert>
    </template>
    {{-- Tlačítko pro přidání další otázky --}}
    <x-ui.button @click="addQuestion()"
                 color="outline-secondary">
        {{ __('pages/poll-editor.questions.button.add_question') }}
    </x-ui.button>

    @error('questions')
    <span class="text-danger ms-2">{{ $message }}</span>
    @enderror
</x-ui.card>
</div>

@push('scripts')
    <script src="{{ asset('js/alpine/questions.js') }}"></script>
@endpush
