<div>

    <form wire:submit.prevent="submit">



        <!-- Obecné informace ankety -->
        <x-card>
            <x-slot:header>General information</x-slot>
            <x-input id="title" model="form.title" type="text" mandatory="true">
                Poll Title
            </x-input>

            <x-textbox id="description" model="form.description">
                Poll description
            </x-textbox>

            <x-input id="deadline" model="form.deadline" type="date">
                Deadline
            </x-input>


            {{-- Informace o autorovi --}}
            @if (!$poll)
                <hr>
                <div>
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
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4">
                    <!-- Kalendář -->
                    <div id='calendar' wire:ignore></div>
                </div>
                <div class="col-lg-6 col-md-12 mb-4">
                    <h3 class="mb-4">Chosen dates</h3>
                    @error('form.dates')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror

                    @foreach ($form->dates as $dateIndex => $date)
                        <x-poll.form.date-card :dateIndex="$dateIndex" :date="$date" />
                    @endforeach


                </div>
            </div>
        </x-card>

        {{-- Výběr doplňujících otázek --}}
        <x-card>
            <x-slot:header>Additional questions</x-slot>

            @if (count($form->questions) == 0)
                <div class="alert alert-secondary" role="alert">
                    No questions added
                </div>
            @else
                @foreach ($form->questions as $questionIndex => $question)
                    <x-poll.form.question-card :questionIndex="$questionIndex" :question="$question" />
                @endforeach

            @endif

            <button type="button" type="button w-25" wire:click="addQuestion()" class="btn btn-outline-secondary">Add
                question</button>

            @error('form.questions')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </x-card>

        {{-- Nastavení ankety --}}
        <x-card>
            <x-slot:header>Poll settings</x-slot>


            <!-- Komentáře -->
            <x-poll.form.checkbox id="comments" model="form.settings.comments">
                Comments
            </x-poll.form.checkbox>

            {{-- Tajné hlasování --}}
            <x-poll.form.checkbox id="anonymous" model="form.settings.anonymous">
                Anonymous voting
            </x-poll.form.checkbox>

            {{-- Skrytí výsledků --}}
            <x-poll.form.checkbox id="hide_results" model="form.settings.hide_results">
                Hide results
            </x-poll.form.checkbox>


            {{-- Pouze pro pozvané --}}
            <x-poll.form.checkbox id="invite_only" model="form.settings.invite_only">
                Invite only
            </x-poll.form.checkbox>

            <x-poll.form.checkbox id="timeOptionsAdded" model="form.settings.time_options">
                User can add time options
            </x-poll.form.checkbox>

            {{-- Heslo --}}
            <x-input id="password" model="form.settings.password" type="password">
                Password
            </x-input>

        </x-card>



        @error('form.save')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">Submit</button>


</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>


<script>
    // Inicializace FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
        console.log('test');
        initCalendar();
    });

    Livewire.hook('message.processed', (message, component) => {
        initCalendar();
    });

    // Inicializace Kalendáře
    function initCalendar() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            dateClick: function(info) {
                //https://stackoverflow.com/questions/77012223/error-only-arrays-and-traversables-can-be-unpacked-when-using-ckeditor-5-with
                Livewire.dispatch('addDate', {
                    date: info.dateStr
                });
            }

        });
        calendar.render();

    }
</script>
