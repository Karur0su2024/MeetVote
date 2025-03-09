<div>

    <form wire:submit.prevent="submit">

        <div class="text-start">
            <!-- Obecné informace ankety -->
            <div class="card mb-5 shadow-sm">
                <div class="card-header">
                    <h2 class="mb-3">General information</h2>
                </div>

                <div class="card-body p-3">
                    <x-input id="title" model="form.title" type="text" label="Poll Title" mandatory="true" />

                    <x-textbox id="description" model="form.description" label="Description" />

                    {{-- Informace o autorovi --}}
                    @if (!$poll)
                        <hr>
                        <div>
                            <x-input id="user_name" model="form.user.name" type="text" label="Your name"
                                     mandatory="true"  />
                            <x-input id="user_email" model="form.user.email" type="email" label="Your email"
                                     mandatory="true"  />
                        </div>
                    @endif




                </div>

            </div>

            <!-- Výběr časových termínů -->
            <div class="card mb-5 shadow-sm">

                <div class="card-header">

                    <h2>Time options</h2>

                </div>

                <div class="card-body p-3">
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

                </div>


            </div>

            <!-- Výběr doplňujících otázek -->
            <div class="card mb-5 shadow-sm">
                <div class="card-header">
                    <h2>Additional questions</h2>
                </div>
                <div class="card-body p-3">

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

                </div>




            </div>

            <!-- Nastavení ankety -->
            <div class="card mb-5 shadow-sm">
                <div class="card-header">
                    <h2>Poll settings</h2>
                </div>
                <div class="card-body p-3">

                    <!-- Komentáře -->
                    <x-poll.form.checkbox id="comments" model="form.settings.comments" label="Comments" />

                    <!-- Tajné hlasování -->
                    <x-poll.form.checkbox id="anonymous" model="form.settings.anonymous" label="Anonymous voting" />

                    <!-- Skryté výsledky -->
                    <x-poll.form.checkbox id="hide_results" model="form.settings.hideResults" label="Hide results" />

                    <x-poll.form.checkbox id="invite_only" model="form.settings.inviteOnly" label="Invite only" />

                    <!-- Heslo -->
                    <x-input id="password" model="form.settings.password" type="password" label="Password" />
                </div>


            </div>
        </div>

        @error('form.save')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror


        <button type="submit" class="btn btn-primary w-75">Submit</button>


    </form>


</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>

    // Inicializace FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
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
