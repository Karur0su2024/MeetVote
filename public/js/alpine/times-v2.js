function TimeOptionsForm() {
    return {
        dates: this.$wire.entangle('form.dates'),
        removed: this.$wire.entangle('form.removed'),
        messages: {
            errors: {},
        },
        dateErrors: {},
        optionErrors: {},

        // Inicializace FullCalendar
        // https://fullcalendar.io/
        initCalendar: function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                themeSystem: 'bootstrap5',
                height: 'auto',
                dateClick: (info) => {
                    this.addDate(info.dateStr);
                },
            });
            calendar.render();
        },

        // Funkce pro přidání nového data do formuláře
        // https://momentjs.com/docs/
        addDate(date) {
            let formattedDate = moment(date).format('YYYY-MM-DD'); // Formát (2025-03-01)

            if (moment(date).isBefore(moment(), 'day')) {
                // Přidat error message pokud je datum před dnešním dnem
                this.messages.errors.calendar = "Date cannot be in the past.";
                return;
            }

            if (this.dates[formattedDate] !== undefined) {
                // Nebo možná nepsat nic
                return;
            }
            else {
                this.dates[formattedDate] = [];
                this.messages.errors.calendar = null;
            }

            this.addTimeOption(formattedDate, true);
        },

        // Odstranění data z formuláře
        removeDate(date) {

            if (Object.keys(this.dates).length === 1) {
                return;
            }

            this.dates[date].forEach(option => {
                if (option.id !== undefined) {
                    this.removed['time_options'].push(option.id);
                }
                // Odstranění časové možnosti z pole pro dané datum
                this.dates[date].splice(this.dates[date].indexOf(option), 1);
            });

            // https://www.geeksforgeeks.org/remove-elements-from-a-javascript-array/
            delete this.dates[date];

        },

        // Funkce pro přidání nové textové možnosti
        addTextOption(date) {
            this.dates[date].push({
                type: "text",
                date: date,
                score: 0,
                invalid: false,
                content: {
                    text: "",
                },
            });
        },

        // Funkce pro přidání nové časové možnosti typu čas
        // Může být automatická nebo prázdná
        addTimeOption(date, empty){
            let lastEnd;
            let end;

            if(empty) {
                lastEnd = this.getLastEnd(date);
                end = moment(lastEnd, 'HH:mm').add(1, 'hour').format('HH:mm');

                if (lastEnd > end) {
                    return;
                }
            }
            else {
                lastEnd = '';
                end = ''
            }

            this.dates[date].push({
                type: 'time',
                date: date,
                score: 0,
                invalid: false,
                content: {
                    start: lastEnd,
                    end: end,
                },
            });
        },

        // Funkce pro odstranění časové možnosti
        removeOption(date, index) {

            // Odstranění časové možnosti z formuláře
            if (this.dates[date].length <= 1 && Object.keys(this.dates).length === 1) {
                // Přidat error message
                return;
            }

            if (this.dates[date][index].id !== undefined) {
                this.removed['time_options'].push(this.dates[date][index].id);
            }

            this.dates[date].splice(index, 1);

            if(this.dates[date].length === 0){
                delete this.dates[date];
            }
        },

        // Zjištění posledního konce časové možnosti pokud existuje
        getLastEnd(dateIndex) {

            let lastEnd = null;
            this.dates[dateIndex].forEach((option) => {
                if (option.type === 'time' && option.content.end !== '') {
                    lastEnd = option.content.end;
                }
            });

            if (lastEnd === null) {
                lastEnd = '00:00';
            }

            return lastEnd;
        },



        // Funkce pro vypsání chybových hlášek
        duplicateError(errors) {
            this.dateErrors = {};
            this.optionErrors = {};

            Object.keys(errors).forEach((key) => {
                //console.log(key);

                dateIndex = key.split('.')[2];

                if(this.dateErrors[dateIndex] === undefined) {
                    this.dateErrors[dateIndex] = '';
                }

                if (!this.dateErrors[dateIndex].includes(errors[key])) {
                    this.dateErrors[dateIndex] += '<li>' + errors[key] + '</li>';
                }


                this.optionErrors[key] = true;

            });

            console.log(this.dateErrors);
            console.log(this.optionErrors);
        }
    }
}
