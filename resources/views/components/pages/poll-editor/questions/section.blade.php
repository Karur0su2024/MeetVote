<div x-data="questionForm" @validation-failed.window="duplicateError($event.detail.errors)">

    <x-ui.card header-hidden>
        <x-slot:body-header>
            <h2 class="mb-3">
                {{ __('pages/poll-editor.questions.title') }}
                <small>
                    <x-ui.tooltip>
                        {{ __('pages/poll-editor.questions.tooltip') }}
                    </x-ui.tooltip>
                </small>
            </h2>
        </x-slot:body-header>

        <x-slot:body>


            <template x-if="questions.length > 0">
                <template x-for="(question, questionIndex) in questions">
                    {{-- Základní informace o anketě --}}
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

            @error('questions')
            <span class="text-danger ms-2">{{ $message }}</span>
            @enderror
        </x-slot:body>
    </x-ui.card>
</div>

@push('scripts')
    <script src="{{ asset('js/alpine/questions.js') }}"></script>
@endpush
