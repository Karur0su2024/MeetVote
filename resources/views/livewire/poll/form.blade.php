<script>
    function getFormData() {
        return {
            form: @entangle('form').defer,
        }
    }
</script>


<div>
    <form wire:submit.prevent="submit" x-data="getFormData">

        <!-- Základní informace o anketě -->
        <x-card>
            <x-slot:header>{{ __('form.section.title.basic_info') }}</x-slot>
            <x-input id="title" wire:model="form.title" type="text" required placeholder="Poll #1">
                {{ __('form.label.title') }}
            </x-input>
            @error('form.title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <x-textbox id="description" model="form.description">
                {{ __('form.label.description') }}
            </x-textbox>

            <x-input id="deadline" wire:model="form.deadline" type="date">
                <x-slot:tooltip>
                    {{ __('form.tooltip.deadline') }}
                </x-slot:tooltip>
                {{ __('form.label.deadline') }}
            </x-input>
            @error('form.deadline')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror


            {{-- Informace o autorovi --}}
            @if (!$poll->id)
                <div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">
                    <x-poll.form.checkbox id="show.user-info" x-model="anonymous">
                        {{ __('form.label.post_anonymously') }}
                    </x-poll.form.checkbox>
                    <div x-show="!anonymous">
                        <x-input id="user_name" wire:model="form.user.name" type="text" required>
                            {{ __('form.label.user_name') }}
                        </x-input>
                        @error('form.user.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <x-input id="user_email" wire:model="form.user.email" type="email">
                        {{ __('form.label.user_email') }}
                    </x-input>
                    @error('form.user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif

        </x-card>

        {{-- Výběr časových termínů --}}
        <x-card>
            <x-slot:header>{{ __('form.section.title.time_options') }}</x-slot>
            <x-slot:tooltip>
                {{ __('form.section.tooltip.time_options') }}
            </x-slot:tooltip>
            <div class="row">
                <x-layouts.col-6>
                    <h3 class="mb-4">Calendar</h3>
                    <div id="js-calendar" class="w-100" wire:ignore></div>
                    @error('form.dates')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </x-layouts.col-6>
                <x-layouts.col-6>
                    <h3 class="mb-4">Chosen dates</h3>
                    @foreach ($form->dates as $dateIndex => $date)
                        <x-poll.form.date-card :dateIndex="$dateIndex" :date="$date" />
                    @endforeach
                </x-layouts.col-6>
            </div>
        </x-card>


        {{-- Možná přesunout do livewire --}}
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
                        class="btn btn-outline-secondary">Add question</button>

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
                    <x-poll.form.checkbox id="comments" wire:model="form.settings.comments">
                        <x-slot:tooltip>
                            Allow participants to add comments to the poll.
                        </x-slot:tooltip>
                        Comments
                    </x-poll.form.checkbox>

                    {{-- Tajné hlasování --}}
                    <x-poll.form.checkbox id="anonymous" wire:model="form.settings.anonymous">
                        <x-slot:tooltip>
                            Allow participants to vote anonymously.
                        </x-slot:tooltip>
                        Anonymous voting
                    </x-poll.form.checkbox>

                    {{-- Skrytí výsledků --}}
                    <x-poll.form.checkbox id="hide_results" wire:model="form.settings.hide_results">
                        <x-slot:tooltip>
                            Hide the results of the poll until the deadline.
                        </x-slot:tooltip>
                        Hide results
                    </x-poll.form.checkbox>

                    {{-- Allow participants to edit their votes --}}
                    <x-poll.form.checkbox id="edit_votes" wire:model="form.settings.edit_votes">
                        <x-slot:tooltip>
                            Allow participants to edit their votes after submission.
                        </x-slot:tooltip>
                        Allow vote editing
                    </x-poll.form.checkbox>

                    {{-- Pouze pro pozvané --}}
                    <x-poll.form.checkbox id="invite_only" wire:model="form.settings.invite_only">
                        <x-slot:tooltip>
                            Permit only invited users to access the poll.
                        </x-slot:tooltip>
                        Invite only
                    </x-poll.form.checkbox>

                    <x-poll.form.checkbox id="add_time_options" wire:model="form.settings.add_time_options">
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

        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">
            {{ __('form.submit') }}
        </button>

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
