<x-card>
    <x-slot:header>{{ __('pages/poll-editor.settings.title') }}</x-slot>

    {{-- Komentáře --}}
    <x-ui.form.checkbox id="comments" x-model="form.settings.comments">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.comments.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.comments.label') }}
    </x-ui.form.checkbox>

    {{-- Tajné hlasování --}}
    <x-ui.form.checkbox id="anonymous" x-model="form.settings.anonymous">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.anonymous.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.anonymous.label') }}
    </x-ui.form.checkbox>

    {{-- Skrytí výsledků --}}
    <x-ui.form.checkbox id="hide_results" x-model="form.settings.hide_results">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.hide_results.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.hide_results.label') }}
    </x-ui.form.checkbox>

    {{-- Účástníci mohou změnit své odpovědi --}}
    <x-ui.form.checkbox id="edit_votes" x-model="form.settings.edit_votes">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.edit_votes.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.edit_votes.label') }}
    </x-ui.form.checkbox>

    {{-- Pouze pro pozvané --}}
    <x-ui.form.checkbox id="invite_only" x-model="form.settings.invite_only">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.invite_only.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.invite_only.label') }}
    </x-ui.form.checkbox>

    {{-- Přidání časových možností --}}
    <x-ui.form.checkbox id="add_time_options" x-model="form.settings.add_time_options">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.add_time_options.label') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.add_time_options.label') }}
    </x-ui.form.checkbox>

    {{-- Heslo --}}
    <x-ui.form.input id="password" x-model="form.settings.password" type="password" error="form.settings.password" error="form.settings.password">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.settings.password.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.settings.password.label') }}
    </x-ui.form.input>
</x-card>
