<x-card>
    <x-slot:header>{{ __('form.section.title.settings') }}</x-slot>

    {{-- Komentáře --}}
    <x-ui.form.checkbox id="comments" x-model="form.settings.comments">
        <x-slot:tooltip>
            {{ __('form.tooltip.comments') }}
        </x-slot:tooltip>
        {{ __('form.label.comments') }}
    </x-ui.form.checkbox>

    {{-- Tajné hlasování --}}
    <x-ui.form.checkbox id="anonymous" x-model="form.settings.anonymous">
        <x-slot:tooltip>
            {{ __('form.tooltip.anonymous') }}
        </x-slot:tooltip>
        {{ __('form.label.anonymous') }}
    </x-ui.form.checkbox>

    {{-- Skrytí výsledků --}}
    <x-ui.form.checkbox id="hide_results" x-model="form.settings.hide_results">
        <x-slot:tooltip>
            {{ __('form.tooltip.hide_results') }}
        </x-slot:tooltip>
        {{ __('form.label.hide_results') }}
    </x-ui.form.checkbox>

    {{-- Účástníci mohou změnit své odpovědi --}}
    <x-ui.form.checkbox id="edit_votes" x-model="form.settings.edit_votes">
        <x-slot:tooltip>
            {{ __('form.tooltip.edit_votes') }}
        </x-slot:tooltip>
        {{ __('form.label.edit_votes') }}
    </x-ui.form.checkbox>

    {{-- Pouze pro pozvané --}}
    <x-ui.form.checkbox id="invite_only" x-model="form.settings.invite_only">
        <x-slot:tooltip>
            {{ __('form.tooltip.invite_only') }}
        </x-slot:tooltip>
        {{ __('form.label.invite_only') }}
    </x-ui.form.checkbox>

    {{-- Přidání časových možností --}}
    <x-ui.form.checkbox id="add_time_options" x-model="form.settings.add_time_options">
        <x-slot:tooltip>
            {{ __('form.tooltip.add_time_options') }}
        </x-slot:tooltip>
        {{ __('form.label.add_time_options') }}
    </x-ui.form.checkbox>

    {{-- Heslo --}}
    <x-ui.form.input id="password" x-model="form.settings.password" type="password" error="form.settings.password" error="form.settings.password">
        <x-slot:tooltip>
            {{ __('form.tooltip.password') }}
        </x-slot:tooltip>
        {{ __('form.label.password') }}
    </x-ui.form.input>
</x-card>
