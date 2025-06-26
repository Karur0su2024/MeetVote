<div class="card bg-base-100 p-3 shadow-sm" x-data="questionForm" @validation-failed.window="duplicateError($event.detail.errors)">
    <h2 class="text-2xl">{{ __('pages/poll-editor.questions.title') }}
        <x-ui.tooltip-new size="sm">
            {{ __('pages/poll-editor.questions.tooltip') }}
        </x-ui.tooltip-new>
    </h2>

    <div class="flex flex-col space-y-3 mb-3">
        <template x-for="(question, questionIndex) in questions">
            {{-- Komponenta s jednou otázkou --}}
            <x-pages.poll-editor.questions-new.question/>
        </template>
        <template x-if="questions.length == 0">
            <x-ui.alert>
                {{ __('pages/poll-editor.questions.alert.no_questions') }}
            </x-ui.alert>
        </template>
    </div>
    <button class="btn"
            type="button"
            @click="addQuestion()">
        {{ __('pages/poll-editor.questions.button.add_question') }}
    </button>

    @error('form.questions')
    <span class="text-danger ms-2">{{ $message }}</span>
    @enderror

</div>

@push('scripts')
    <script src="{{ asset('js/alpine/questions.js') }}"></script>
@endpush
