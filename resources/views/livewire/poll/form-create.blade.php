<div>

    <form wire:submit.prevent="submit">

        <div class="text-start">
            <!-- Obecné informace ankety -->
            <div class="card mb-5 p-3">

                <h2 class="mb-3">General information</h2>
                <x-input id="title" model="title" type="text" label="Poll Title" />

                <div class="mb-3">
                    <label class="form-label">Poll Description</label>
                    <textarea wire:model="description" class="form-control"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <x-input id="user_name" model="user_name" type="text" label="Your name" />

                <x-input id="user_email" model="user_email" type="email" label="Your email" />


            </div>

            <!-- Výběr časových termínů -->
            <div class="card mb-5">

                <div class="card-header">

                    <h2>Time options</h2>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">

                            <!-- Přidat kalendář -->
                            Kalendář
                            <button type="button" wire:click="addDate('1-1-2020')">Přidat datum</button>
                        </div>
                        <div class="col-6">
                            <h3>Vybraná data</h3>

                            @foreach ($dates as $dateIndex => $date)
                                <x-poll.form.date-card :dateIndex="$dateIndex" :date="$date" />
                            @endforeach


                        </div>
                    </div>

                </div>


            </div>

            <!-- Výběr doplňujících otázek -->
            <div class="card mb-5 p-3">

                <h2 class="mb-3">Additional questions</h2>

            </div>

            <!-- Nastavení ankety -->
            <div class="card mb-5 p-3">
                <h2 class="mb-3">Poll settings</h2>

                <!-- Heslo -->
                <x-poll.form.checkbox id="comments" model="settings.comments" label="Comments" />

                <!-- Tajné hlasování -->
                <x-poll.form.checkbox id="anonymous" model="settings.anonymous" label="Anonymous voting" />

                <!-- Skryté výsledky -->
                <x-poll.form.checkbox id="hide_results" model="settings.hide_results" label="Hide results" />



            </div>
        </div>



        <button type="submit" class="btn btn-primary w-75">Submit</button>

    </form>


</div>
