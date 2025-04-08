function getVotingData() {
    return {
        form: this.$wire.entangle('form'),
        messages: {
            errors: {},
            success: '',
        },

        // Nastavení preference pro časovou možnost nebo otázku
        setPreference(type, questionIndex, optionIndex, preference) {
            if (type === 'timeOption') {
                if(this.form.timeOptions[optionIndex].invalid){
                    return
                }
                this.form.timeOptions[optionIndex].picked_preference = preference;
            } else if (type == 'question') {
                this.form.questions[questionIndex].options[optionIndex].picked_preference = preference;
            }
        },

        // Získání další preference
        getNextPreference(type, currentPreference) {
            if (type === "timeOption") {
                switch (currentPreference) {
                    case 0:
                        return 2;
                    case 2:
                        return 1;
                    case 1:
                        return -1;
                    case -1:
                        return 0;
                }
            } else {
                switch (currentPreference) {
                    case 0:
                        return 2;
                    case 2:
                        return 0;
                }
            }
        },
    }
}
