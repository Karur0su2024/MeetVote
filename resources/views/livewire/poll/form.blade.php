<div>
    <form wire:submit.prevent="submit">

        <!-- Obecné informace ankety -->
        <x-card>
            <x-slot:header>General information</x-slot>
            <x-input id="title" model="form.title" type="text" required
                placeholder="Poll #1">
                Poll Title
            </x-input>

            <x-textbox id="description" model="form.description">
                Poll description
            </x-textbox>

            <x-input id="deadline" model="form.deadline" type="date">
                <x-slot:tooltip>
                    Set the deadline for the poll. After this date, no new votes will be accepted. Deadline is not
                    required
                </x-slot:tooltip>
                Deadline
            </x-input>


            {{-- Informace o autorovi --}}
            @if (!$poll->id)
                <div x-data="{ show: @entangle('form.showUserInfo') }">
                    <x-poll.form.checkbox id="show_user_info" model="form.showUserInfo">
                        <x-slot:tooltip>
                            Show your name and email to the participants of the poll.
                        </x-slot:tooltip>
                        Show my name and email
                    </x-poll.form.checkbox>
                    <x-input id="user_name" model="form.user.name" type="text" mandatory="true">
                        Your name
                    </x-input>

                    <x-input id="user_email" model="form.user.email" type="email" mandatory="true">
                        Your email
                    </x-input>
                </div>
            @endif

        </x-card>

        {{-- Výběr časových termínů --}}
        <x-card>
            <x-slot:header>Time options</x-slot>
            <x-slot:tooltip>
                Select available dates and time slots for participants to vote on.
            </x-slot:tooltip>
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <h3 class="mb-4">Calendar</h3>
                    <div id="js-calendar" class="w-100" wire:ignore></div>
                    @error('form.dates')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <h3 class="mb-4">Chosen dates</h3>


                    @foreach ($form->dates as $dateIndex => $date)
                        <x-poll.form.date-card :dateIndex="$dateIndex" :date="$date" />
                    @endforeach


                </div>
            </div>

        </x-card>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3">
                {{-- Výběr doplňujících otázek --}}
                <x-card>
                    <x-slot:header>Additional questions</x-slot>
                    <x-slot:tooltip>
                        Add additional questions to the poll. Questions are not required.
                    </x-slot:tooltip>

                    @if (count($form->questions) == 0)
                        <div class="alert alert-secondary" role="alert">
                            No questions added
                        </div>
                    @else
                        @foreach ($form->questions as $questionIndex => $question)
                            <x-poll.form.question-card :questionIndex="$questionIndex" :question="$question" />
                        @endforeach

                    @endif

                    <button type="button" type="button w-25" wire:click="addQuestion()"
                        class="btn btn-outline-secondary">Add
                        question</button>

                    @error('form.questions')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </x-card>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                {{-- Nastavení ankety --}}
                <x-card>
                    <x-slot:header>Poll settings</x-slot>

                    <!-- Komentáře -->
                    <x-poll.form.checkbox id="comments" model="form.settings.comments">
                        <x-slot:tooltip>
                            Allow participants to add comments to the poll.
                        </x-slot:tooltip>
                        Comments
                    </x-poll.form.checkbox>

                    {{-- Tajné hlasování --}}
                    <x-poll.form.checkbox id="anonymous" model="form.settings.anonymous">
                        <x-slot:tooltip>
                            Allow participants to vote anonymously.
                        </x-slot:tooltip>
                        Anonymous voting
                    </x-poll.form.checkbox>

                    {{-- Skrytí výsledků --}}
                    <x-poll.form.checkbox id="hide_results" model="form.settings.hide_results">
                        <x-slot:tooltip>
                            Hide the results of the poll until the deadline.
                        </x-slot:tooltip>
                        Hide results
                    </x-poll.form.checkbox>

                    {{-- Allow participants to edit their votes --}}
                    <x-poll.form.checkbox id="edit_votes" model="form.settings.edit_votes">
                        <x-slot:tooltip>
                            Allow participants to edit their votes after submission.
                        </x-slot:tooltip>
                        Allow vote editing
                    </x-poll.form.checkbox>

                    {{-- Pouze pro pozvané --}}
                    <x-poll.form.checkbox id="invite_only" model="form.settings.invite_only">
                        <x-slot:tooltip>
                            Permit only invited users to access the poll.
                        </x-slot:tooltip>
                        Invite only
                    </x-poll.form.checkbox>

                    <x-poll.form.checkbox id="add_time_options" model="form.settings.add_time_options">
                        <x-slot:tooltip>
                            Allow participants to add their own time options to the poll.
                        </x-slot:tooltip>
                        User can add time options
                    </x-poll.form.checkbox>

                    {{-- Heslo --}}
                    <x-input id="password" model="form.settings.password" type="password">
                        <x-slot:tooltip>
                            Set a password for the poll. Only users with the password can access the poll.
                        </x-slot:tooltip>
                        Password
                    </x-input>

                </x-card>
            </div>
        </div>


        @error('form.error')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">Submit</button>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var calendar = new jsCalendar("#js-calendar");

        calendar.onDateClick(function(event, date) {
            addDate(date);
            console.log(date);
        });
    });

    function addDate(date) {
        Livewire.dispatch('addDate', {
            date: date
        });
    }
</script>
