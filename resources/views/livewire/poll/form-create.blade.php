<div>

    <form wire:submit.prevent="submit">

        <div class="text-left">
            <!-- Obecné informace ankety -->
            <div class="card mb-5 p-3">

                <div class="mb-3">
                    <label class="form-label">Poll Title *</label>
                    <input type="text" wire:model="title" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Poll Description</label>
                    <textarea wire:model="description" class="form-control"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Your name *</label>
                    <input type="text" wire:model="user_name" class="form-control">
                    @error('user_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Your email *</label>
                    <input type="email" wire:model="user_email" class="form-control">
                    @error('user_email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!-- Výběr časových termínů -->
            <div class="card mb-5 p-3">

            </div>

            <!-- Výběr doplňujících otázek -->
            <div class="card mb-5 p-3">

            </div>

            <!-- Nastavení ankety -->
            <div class="card mb-5 p-3">

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
