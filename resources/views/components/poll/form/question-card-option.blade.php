<div class="d-flex align-items-center gap-2 mb-3">

    {{-- Input pole pro text možnosti --}}
    <input type="text"
        :id="'question_' + questionIndex + '_option_' + optionIndex"
        x-model="form.questions[questionIndex].options[optionIndex].text"
        :placeholder="'Option ' + (optionIndex + 1)" class="form-control" required>

    {{-- Tlačítko pro odstranění možnosti --}}
    <button type="button" @click="removeQuestionOption(questionIndex, optionIndex)"
        class="btn btn-danger"><i class="bi bi-trash"></i>
    </button>
</div>
