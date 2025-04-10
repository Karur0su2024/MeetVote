<x-ui.card collapsable>
    <x-slot:header>{{ __('pages/poll-editor.settings.title') }}</x-slot>

    <h4 class="text-muted mb-3">
        Poll settings
    </h4>
    {{-- Komentáře --}}
    <x-ui.form.checkbox id="comments" wire:model="form.settings.comments">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.comments.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.comments.label') }}
    </x-ui.form.checkbox>

    {{-- Tajné hlasování --}}
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

    {{-- Účástníci mohou změnit své odpovědi --}}
    <x-ui.form.checkbox id="edit_votes" wire:model="form.settings.edit_votes">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.edit_votes.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.edit_votes.label') }}
    </x-ui.form.checkbox>

    {{-- Přidání časových možností --}}
    <x-ui.form.checkbox id="add_time_options" wire:model="form.settings.add_time_options">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.add_time_options.label') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.add_time_options.label') }}
    </x-ui.form.checkbox>



    <h4 class="text-muted mb-3">
        Poll security
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


    <div x-data="{ password:  @entangle('form.password') }">
        <div x-show="password.set !== null">
            <x-ui.button color="danger"
                         @click="password.set = null">
                Password is set, click to remove
            </x-ui.button>
        </div>

        <div x-show="password.set === null" x-collapse>
            <x-ui.form.checkbox id="password_enabled"
                                x-model="password.enabled"
                                margin="m-0">
                <x-slot:tooltip>
                    {{ __('pages/poll-editor.settings.password.tooltip') }}
                </x-slot:tooltip>
                {{ __('pages/poll-editor.settings.password.label') }}
            </x-ui.form.checkbox>

            <div x-show="password.enabled" x-collapse>
                <x-ui.form.input id="password"
                                 x-model="password.value"
                                 type="password"
                                 placeholder="{{ __('pages/poll-editor.settings.password.placeholder') }}"
                                 error="form.password" />
            </div>

        </div>


    </div>


    {{-- Heslo --}}

</x-ui.card>
