function questionForm() {
    return {
        questions: this.$wire.entangle('form.questions'),
        removed: this.$wire.entangle('form.removed'),
        messages: {
            errors: {},
        },

        // Funkce pro přidání nové otázky
        addQuestion() {
            this.questions.push({
                text: '',
                options: [{
                    text: '',
                    score: 0,
                },
                    {
                        text: '',
                        score: 0,
                    }
                ],
            });
        },

        // Funkce pro odstranění otázky
        removeQuestion(index) {
            if (this.questions[index].id !== undefined) {
                this.removed['questions'].push(this.questions[index].id);
            }


            this.questions.splice(index, 1);
        },

        // Funkce pro přidání nové možnosti otázky
        addQuestionOption(questionIndex) {
            this.questions[questionIndex].options.push({
                text: '',
                score: 0,
            });
        },

        // Funkce pro odstranění možnosti otázky
        removeQuestionOption(questionIndex, optionIndex) {
            if (this.questions[questionIndex].options.length <= 2) {
                // Přidat error message
                return;
            }

            if (this.questions[questionIndex].options[optionIndex].id !== undefined) {
                this.removed['question_options'].push(this.questions[questionIndex].options[optionIndex].id);
            }

            this.questions[questionIndex].options.splice(optionIndex, 1);
        },

        duplicateError(errors) {
            this.messages.errors = errors;

        }

    }
}
