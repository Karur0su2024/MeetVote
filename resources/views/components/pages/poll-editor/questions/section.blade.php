<div x-data="questionForm" @validation-failed.window="duplicateError($event.detail.errors)">
    <x-ui.tw-card>
        <x-slot:title>
            {{ __('pages/poll-editor.questions.title') }}
            <small>
                <x-ui.tooltip>
                    {{ __('pages/poll-editor.questions.tooltip') }}
                </x-ui.tooltip>
            </small>
        </x-slot:title>

        <template x-if="questions.length > 0">
            <template x-for="(question, questionIndex) in questions">
                {{-- Komponenta s jednou otázkou --}}
                <x-pages.poll-editor.questions.question/>

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

        @error('form.questions')
        <span class="text-danger ms-2">{{ $message }}</span>
        @enderror
    </x-ui.tw-card>


</div>

@push('scripts')
    <script src="{{ asset('js/alpine/questions.js') }}"></script>
@endpush
