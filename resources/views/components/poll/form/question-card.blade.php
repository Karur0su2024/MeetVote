@props([
    'questionIndex', // Index otázky
    'question', // Data otázky
])

<div class="card mb-3">
    <!-- Hlavička otázky -->
    <div class="card-header d-flex justify-content-between align-items-center gap-2">


        {{-- Input pole pro text otázky --}}
        <input type="text" id="question_{{ $questionIndex }}" wire:model="form.questions.{{ $questionIndex }}.text"
            class="form-control" placeholder="Question {{ $questionIndex + 1 }}">


        {{-- Tlačítko pro odstranění otázky --}}
        <button type="button" wire:click="removeQuestion('{{ $questionIndex }}')" class="btn btn-danger">
            X
        </button>
    </div>

    {{-- Možnosti odpovědí --}}
    <div class="card-body">
        @foreach ($question['options'] as $optionIndex => $option)
            <div class="d-flex align-items-center gap-2 mb-3">
                {{-- Input pole pro text možnosti --}}
                <input type="text" wire:model="form.questions.{{ $questionIndex }}.options.{{ $optionIndex }}.text"
                    placeholder="Option {{ $optionIndex + 1 }}" class="form-control">

                {{-- Tlačítko pro odstranění možnosti --}}
                <button type="button" wire:click="removeQuestionOption('{{ $questionIndex }}', '{{ $optionIndex }}')"
                    class="btn btn-danger">X
                </button>
            </div>

            {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
        @endforeach


        {{-- Tlačítko pro přidání možnosti --}}
        <button type="button" wire:click="addQuestionOption('{{ $questionIndex }}')" class="btn btn-outline-secondary">
            Add option</button>
        @error("form.questions.{$questionIndex}.*")
            <div class="alert alert-danger mt-3 mb-0" role="alert">
                {{ $message }}
            </div>
        @enderror

    </div>
</div>
