<x-ui.card collapsable>
    {{-- Hlavička --}}
    <x-slot:header>{{ __('pages/poll-editor.basic_info.title') }}</x-slot:header>

    <div x-show="show">
        {{-- Název ankety --}}
        <x-ui.form.input
            id="title"
            x-model="form.title"
            type="text"
            placeholder="{{ __('pages/poll-editor.basic_info.poll_title.placeholder') }}"

            x-error="form.title">
            {{ __('pages/poll-editor.basic_info.poll_title.label') }}
        </x-ui.form.input>

        {{-- Popis ankety --}}
        <x-ui.form.textbox
            id="description"
            x-model="form.description"
            placeholder="{{ __('pages/poll-editor.basic_info.poll_description.placeholder') }}"
            error="form.description">
            {{ __('pages/poll-editor.basic_info.poll_description.label') }}
        </x-ui.form.textbox>

        {{-- Deadline ankety --}}
        <x-ui.form.input
            id="deadline"
            x-model="form.deadline"
            type="date"
            error="form.deadline">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.basic_info.poll_deadline.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.basic_info.poll_deadline.label') }}
        </x-ui.form.input>

        {{-- Informace o autorovi --}}
        @if (!$pollIndex)
            <x-pages.poll-editor.author-info-section />
        @endif
    </div>


</x-ui.card>
