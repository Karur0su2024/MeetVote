<div>

    <form wire:submit.prevent="submit">

        <div class="text-start">
            <!-- Obecné informace ankety -->
            <div class="card mb-5">
                <div class="card-header">
                    <h2 class="mb-3">General information</h2>
                </div>

                <div class="card-body p-3">
                    <x-input id="title" model="title" type="text" label="Poll Title" mandatory="true"  />

                    <div class="mb-3">
                        <label class="form-label">Poll Description</label>
                        <textarea wire:model="description" class="form-control"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-input id="deadline" model="deadline" type="date" label="Deadline" />

                    <hr>

                    {{-- Informace o autorovi --}}
                    <div>
                        <x-input id="user_name" model="userName" type="text" label="Your name" />

                        <x-input id="user_email" model="userEmail" type="email" label="Your email" mandatory="true" />


                    </div>

                </div>

            </div>

            <!-- Výběr časových termínů -->
            <div class="card mb-5">

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

                            @foreach ($dates as $dateIndex => $date)
                                <x-poll.form.date-card :dateIndex="$dateIndex" :date="$date" />
                            @endforeach


                        </div>
                    </div>

                </div>


            </div>

            <!-- Výběr doplňujících otázek -->
            <div class="card mb-5">
                <div class="card-header">
                    <h2>Additional questions</h2>
                </div>
                <div class="card-body p-3">
                    @if (count($questions) == 0)
                        <div class="alert alert-secondary" role="alert">
                            No questions added
                        </div>
                    @else
                        @foreach ($questions as $questionIndex => $question)
                            <x-poll.form.question-card :questionIndex="$questionIndex" :question="$question" />
                        @endforeach

                    @endif

                    <button type="button" type="button w-25" wire:click="addQuestion" class="btn btn-outline-secondary">Add
                        question</button>
                </div>




            </div>

            <!-- Nastavení ankety -->
            <div class="card mb-5">
                <div class="card-header">
                    <h2>Poll settings</h2>
                </div>
                <div class="card-body p-3">

                    <!-- Komentáře -->
                    <x-poll.form.checkbox id="comments" model="settings.comments" label="Comments" />

                    <!-- Tajné hlasování -->
                    <x-poll.form.checkbox id="anonymous" model="settings.anonymous" label="Anonymous voting" />

                    <!-- Skryté výsledky -->
                    <x-poll.form.checkbox id="hide_results" model="settings.hideResults" label="Hide results" />

                    <x-poll.form.checkbox id="invite_only" model="settings.inviteOnly" label="Invite only" />

                    <!-- Heslo -->
                    <x-input id="password" model="settings.password" type="password" label="Password" />
                </div>


            </div>
        </div>

        <button type="submit" class="btn btn-primary w-75">Submit</button>

    </form>


</div>
