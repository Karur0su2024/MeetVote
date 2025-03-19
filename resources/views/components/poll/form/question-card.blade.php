<div class="card mb-3 shadow-sm">
    <!-- Hlavička otázky -->
    <div class="card-header d-flex justify-content-between align-items-center gap-2">
        {{-- Input pole pro text otázky --}}
        <input type="text" :id="'question_' + questionIndex" x-model="form.questions[questionIndex].text"
            class="form-control" :placeholder="'Question ' + (questionIndex + 1)" required>

        {{-- Tlačítko pro odstranění otázky --}}
        <button type="button" @click="removeQuestion(questionIndex)" class="btn btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </div>

    {{-- Možnosti odpovědí --}}
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
