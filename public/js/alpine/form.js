function getFormData() {
    return {
        form: this.$wire.entangle('form'),
        messages: {
            errors: {},
        },

        // Inicializace jskalendáře
        // https://gramthanos.github.io/jsCalendar/docs.html#javascript-method-min-max
        initCalendar: function () {
            let calendar = new jsCalendar("#js-calendar");
            calendar.min("now");
            calendar.onDateClick((event, date) => {
                this.addDate(date); // Přidání data do formuláře
            });
        },

        // Funkce pro přidání data do formuláře
        // https://momentjs.com/docs/
        addDate(date) {
            let formattedDate = moment(date).format('YYYY-MM-DD'); // Formát (2025-03-01)

            if (moment(date).isBefore(moment(), 'day')) {
                // Přidat error message pokud je datum před dnešním dnem
                return;
            }

            if (this.form.dates[formattedDate] !== undefined) {
                // Přidat error message pokud je datum již přidáno
                // Nebo možná nepsat nic
                return;
            }

            this.addTimeOption(formattedDate, 'time');
        },

        // Odstranění data z formuláře
        removeDate(date) {

            if(Object.keys(this.form.dates).length <= 1) {
                // Přidat error message pokud se jedná o poslední datum
                return;
            }

            this.form.dates[date].forEach(option => {
                if (option.id !== undefined) {
                    this.form.removed['time_options'].push(option.id);
                }
                // Odstranění časové možnosti z pole pro dané datum
                this.form.dates[date].splice(this.form.dates[date].indexOf(option), 1);
            });

            // https://www.geeksforgeeks.org/remove-elements-from-a-javascript-array/
            delete this.form.dates[date];

        },

        // Funkce pro přidání časové možnosti
        addTimeOption(date, type, empty) {


            // Přidání časové možnosti do formuláře
            if (this.form.dates[date] === undefined) {
                this.form.dates[date] = [];
            }

            // Kontrola typu možnosti
            if (type === 'time') {
                if(empty){
                    this.form.dates[date].push({
                        type: type,
                        date: date,
                        content: {
                            start: '',
                            end: '',
                        },
                    });
                }
                else {
                    let lastEnd = this.getLastEnd(date);
                    let end = moment(lastEnd, 'HH:mm').add(1, 'hour').format('HH:mm');

                    if(lastEnd > end) {
                        return;
                    }

                    this.form.dates[date].push({
                        type: type,
                        date: date,
                        content: {
                            start: lastEnd,
                            end: end,
                        },
                    });
                }

            } else {
                this.form.dates[date].push({
                    type: type,
                    date: date,
                    content: {
                        text: "",
                    },
                });
            }

        },

        removeTimeOption(date, index) {

            // Odstranění časové možnosti z formuláře
            if (this.form.dates[date].length <= 1) {
                // Přidat error message
                return;
            }

            if (this.form.dates[date][index].id !== undefined) {
                this.form.removed['time_options'].push(this.form.dates[date][index].id);
            }

            this.form.dates[date].splice(index, 1);
        },

        // Zjištění posledního konce časového intervalu pokud existuje
        getLastEnd(dateIndex) {

            let lastEnd = null;
            this.form.dates[dateIndex].forEach((option) => {
                if (option.type === 'time' && option.content.end !== '') {
                    lastEnd = option.content.end;
                }
            });

            if (lastEnd === null) {
                lastEnd = moment().format('HH:mm');
            }

            return lastEnd;
        },

        // Funkce pro otázky
        addQuestion() {
            this.form.questions.push({
                text: '',
                options: [{
                    text: '',
                },
                    {
                        text: '',
                    }
                ],
            });
        },

        removeQuestion(index) {
            if (this.form.questions[index].id !== undefined) {
                this.form.removed['questions'].push(this.form.questions[index].id);
            }



            this.form.questions.splice(index, 1);
        },

        addQuestionOption(questionIndex) {
            this.form.questions[questionIndex].options.push({
                text: '',
            });
        },

        removeQuestionOption(questionIndex, optionIndex) {
            if (this.form.questions[questionIndex].options.length <= 2) {
                // Přidat error message
                return;
            }

            if (this.form.questions[questionIndex].options[optionIndex].id !== undefined) {
                this.form.removed['question_options'].push(this.form.questions[questionIndex].options[optionIndex].id);
            }

            this.form.questions[questionIndex].options.splice(optionIndex, 1);
        },


        duplicateError(errors) {
            this.messages.errors = errors;
        }
    }
}
