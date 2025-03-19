function getFormData() {
    return {
        form: this.$wire.entangle('form'),

        initCalendar() {
            var calendar = new jsCalendar("#js-calendar");
            calendar.min("now");
            calendar.onDateClick((event, date) => {
                this.addDate(date);
                console.log(this.form.dates);
            });
        },

        addDate(date) {
            formattedDate = moment(date).format('YYYY-MM-DD');

            if (moment(date).isBefore(moment(), 'day')) {
                console.log(moment(date).isBefore(moment(), 'day'));
                // Přidat error message
                return;
            }

            if (this.form.dates[formattedDate] !== undefined) {
                // Přidat error message
                return;
            }

            this.form.dates[formattedDate] = [{
                type: 'time',
                content: {
                    start: moment().format('HH:mm'),
                    end: moment().add(1, 'hour').format('HH:mm'),
                }
            }
            ];
        },

        removeDate(date) {
            if (this.form.dates.length <= 1) {
                // Přidání error message
                return;
            }


            // Přidat odstranění pro všechny položky uvnitř data
            // A přidat je do pole pro odstranění pokud obsahují ID

            // https://www.geeksforgeeks.org/remove-elements-from-a-javascript-array/
            delete this.form.dates[date];

        },

        // Funkce pro přidání časové možnosti
        addTimeOption(date, type) {


            // Přidání časové možnosti do formuláře
            if (this.form.dates[date] === undefined) {
                this.form.dates[date] = [];
            }



            // Kontrola typu možnosti
            if (type === 'time') {
                let lastEnd = this.getLastEnd(date);
                this.form.dates[date].push({
                    type: type,
                    date: date,
                    content: {
                        start: lastEnd,
                        end: moment(lastEnd, 'HH:mm').add(1, 'hour').format('HH:mm'),
                    },
                });
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
                if (option.type === 'time') {
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
                this.form.removed['questions_options'].push(this.form.questions[questionIndex].options[optionIndex].id);
            }

            this.form.questions[questionIndex].options.splice(optionIndex, 1);
        },
    }
}
