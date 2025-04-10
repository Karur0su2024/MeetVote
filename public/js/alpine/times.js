function setTimeOptions() {
    return {
        dates: this.$wire.entangle('form.dates'),
        removed: this.$wire.entangle('form.removed'),
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

            if (this.dates[formattedDate] !== undefined) {
                // Přidat error message pokud je datum již přidáno
                // Nebo možná nepsat nic
                return;
            }

            this.addTimeOption(formattedDate, 'time');
        },

        // Odstranění data z formuláře
        removeDate(date) {

            if (Object.keys(this.dates).length <= 1) {
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

        // Funkce pro přidání časové možnosti
        addTimeOption(date, type, empty) {


            // Přidání časové možnosti do formuláře
            if (this.dates[date] === undefined) {
                this.dates[date] = [];
            }

            // Kontrola typu možnosti
            if (type === 'time') {
                if (empty) {
                    this.dates[date].push({
                        type: type,
                        date: date,
                        content: {
                            start: '',
                            end: '',
                        },
                    });
                } else {
                    let lastEnd = this.getLastEnd(date);
                    let end = moment(lastEnd, 'HH:mm').add(1, 'hour').format('HH:mm');

                    if (lastEnd > end) {
                        return;
                    }

                    this.dates[date].push({
                        type: type,
                        date: date,
                        content: {
                            start: lastEnd,
                            end: end,
                        },
                    });
                }

            } else {
                this.dates[date].push({
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
                lastEnd = moment().format('HH:mm');
            }

            return lastEnd;
        },



        duplicateError(errors) {
            this.messages.errors = errors;
        }
    }
}
