function TimeOptionsForm() {
    return {
        dates: this.$wire.entangle('form.dates'),
        removed: this.$wire.entangle('form.removed'),
        messages: {
            errors: {},
        },

        // Inicializace jskalendáře
        // https://fullcalendar.io/
        initCalendar: function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                height: 'auto',
                dateClick: (info) => {
                    this.addDate(info.dateStr);
                },
            });
            calendar.render();
        },

        // Funkce pro přidání data do formuláře
        // https://momentjs.com/docs/
        addDate(date) {
            let formattedDate = moment(date).format('YYYY-MM-DD'); // Formát (2025-03-01)

            if (moment(date).isBefore(moment(), 'day')) {
                // Přidat error message pokud je datum před dnešním dnem
                return;
            }

            if (this.dates[formattedDate] !== undefined) {
                // Přidat error message pokud je datum již přidáno
                // Nebo možná nepsat nic
                return;
            }
            else {
                this.dates[formattedDate] = [];
            }

            this.addTimeOption(formattedDate, true);
        },

        // Odstranění data z formuláře
        removeDate(date) {

            if (Object.keys(this.dates).length === 1) {
                // Přidat error message pokud se jedná o poslední datum
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

        addTextOption(date) {
            this.dates[date].push({
                type: "text",
                date: date,
                score: 0,
                content: {
                    text: "",
                },
            });
        },

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
                content: {
                    start: lastEnd,
                    end: end,
                },
            });
        },


        removeOption(date, index) {

            // Odstranění časové možnosti z formuláře
            if (this.dates[date].length <= 1) {
                // Přidat error message
                return;
            }

            if (this.dates[date][index].id !== undefined) {
                this.removed['time_options'].push(this.dates[date][index].id);
            }

            this.dates[date].splice(index, 1);
        },

        // Zjištění posledního konce časového intervalu pokud existuje
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



        duplicateError(errors) {
            this.messages.errors = errors;
        }
    }
}
