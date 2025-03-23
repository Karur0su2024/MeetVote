function votingData() {
    return {
        poll: this.$wire.entangle('poll'),
        form: this.$wire.entangle('form'),
        isSubmitting: false,
        messages: {
            errors: {},
            success: '',
        },


        submitVotes() {
            this.isSubmitting = true;
            this.messages.errors = {};
            this.messages.success = '';

            // Zjištění, zda je vybrána alespoň jedna možnost
            if (!this.checkIfSelected()) {
                this.isSubmitting = false;
                return;
            }

            // Odeslání hlasu
            Livewire.dispatch('submitVote', {
                voteData: this.form,
            });
        },

        openModal(alias) {
            Livewire.dispatch('showModal', {
                data: {
                    alias: 'modals.poll.' + alias,
                    params: {
                        pollIndex: this.poll.id
                    }
                },
            });
        },

        setPreference(type, questionIndex, optionIndex, preference) {
            if (type == 'timeOption') {
                this.form.timeOptions[optionIndex].picked_preference = preference;
            } else if (type == 'question') {
                this.form.questions[questionIndex].options[optionIndex].picked_preference = preference;
            }
        },

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

        checkIfSelected() {
            for (i = 0; i < this.form.timeOptions.length; i++) {
                if (this.form.timeOptions[i].picked_preference !== 0) {
                    return true;
                }
            }
            for (i = 0; i < this.form.questions.length; i++) {
                for (j = 0; j < this.form.questions[i].options.length; j++) {
                    if (this.form.questions[i].options[j].picked_preference !== 0) {
                        return true;
                    }
                }
            }

            this.messages.errors.form = "You have to select at least one option.";

            return false;
        },

        unsuccessfulVote(errors) {
            this.isSubmitting = false;
            this.messages.errors = errors;
        },

        successfulVote() {
            this.isSubmitting = false;
            this.messages.errors = {};
            this.messages.success = "Your vote has been successfully submitted.";
            //this.form = @json($form);
        },

        refreshPoll(formData) {
            this.form = formData
            this.isSubmitting = false;
            this.messages.errors = {};

            if (this.form.existingVote != null) {
                this.messages.success = "Vote has been loaded.";
            }
        },

        test() {
            console.log('test');
            console.log(this.form);
            console.log(this.poll);
        }
    }
}
