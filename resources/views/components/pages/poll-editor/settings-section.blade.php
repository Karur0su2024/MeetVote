<x-ui.card header-hidden>
    <x-slot:body-header>
        <h2 class="mb-3">
            {{ __('pages/poll-editor.settings.title') }}
        </h2>
    </x-slot:body-header>

    <x-slot:body>


        <h4 class="text-muted mb-3">
            {{ __('pages/poll-editor.settings.section_titles.settings') }}
        </h4>
        {{-- Komentáře --}}
        <x-ui.form.checkbox id="comments" wire:model="form.settings.comments">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.settings.comments.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.settings.comments.label') }}
        </x-ui.form.checkbox>

        {{-- Anonymní hlasování --}}
        <x-ui.form.checkbox id="anonymous" wire:model="form.settings.anonymous_votes">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.settings.anonymous.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.settings.anonymous.label') }}
        </x-ui.form.checkbox>

        {{-- Skrytí výsledků --}}
        <x-ui.form.checkbox id="hide_results" wire:model="form.settings.hide_results">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.settings.hide_results.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.settings.hide_results.label') }}
        </x-ui.form.checkbox>

        {{-- Přidání časových možností --}}
        <x-ui.form.checkbox id="add_time_options" wire:model="form.settings.add_time_options">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.settings.add_time_options.label') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.settings.add_time_options.label') }}
        </x-ui.form.checkbox>

        <x-ui.form.checkbox id="add_time_options" wire:model="form.settings.allow_invalid">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.settings.allow_invalid.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.settings.allow_invalid.label') }}
        </x-ui.form.checkbox>

        <h4 class="text-muted mb-3">
            {{ __('pages/poll-editor.settings.section_titles.security') }}
        </h4>

        @auth
            {{-- Pouze pro pozvané --}}
            <x-ui.form.checkbox id="invite_only" wire:model="form.settings.invite_only">
                <x-slot:tooltip>
                    {{ __('pages/poll-editor.settings.invite_only.tooltip') }}
                </x-slot:tooltip>
                {{ __('pages/poll-editor.settings.invite_only.label') }}
            </x-ui.form.checkbox>
        @endauth

        {{-- Nastavení hesla --}}
        <div x-data="{ password:  @entangle('form.password') }">
            <div x-show="password.set !== null">
                <x-ui.button color="danger"
                             @click="password.set = null">
                    Password is set, click to remove
                </x-ui.button>
            </div>

            <div x-show="password.set === null" x-collapse>
                <x-ui.form.input id="password"
                                 x-model="password.value"
                                 type="password"
                                 placeholder="{{ __('pages/poll-editor.settings.password.placeholder') }}"
                                 error="form.password">
                    <x-slot:tooltip>
                        {{ __('pages/poll-editor.settings.password.tooltip') }}
                    </x-slot:tooltip>
                    {{ __('pages/poll-editor.settings.password.label') }}
                </x-ui.form.input>


            </div>


        </div>

    </x-slot:body>

</x-ui.card>
