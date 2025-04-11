<x-ui.card collapsable>
    {{-- Hlavička --}}
    <x-slot:header>{{ __('pages/poll-editor.basic_info.title') }}</x-slot:header>

    <div x-show="show">
        {{-- Název ankety --}}

        <div class="mb-3">
            <h4 class="text-muted mb-3">
                {{ __('pages/poll-editor.basic_info.section.poll') }}
            </h4>


            <x-ui.form.input
                id="title"
                wire:model="form.title"
                type="text"
                placeholder="{{ __('pages/poll-editor.basic_info.poll_title.placeholder') }}"
                required>
                {{ __('pages/poll-editor.basic_info.poll_title.label') }}
            </x-ui.form.input>

            {{-- Popis ankety --}}
            <x-ui.form.textbox
                id="description"
                wire:model="form.description"
                placeholder="{{ __('pages/poll-editor.basic_info.poll_description.placeholder') }}">
                {{ __('pages/poll-editor.basic_info.poll_description.label') }}
            </x-ui.form.textbox>

            {{-- Deadline ankety --}}
            <x-ui.form.input
                id="deadline"
                wire:model="form.deadline"
                type="date">
                <x-slot:tooltip>
                    {{ __('pages/poll-editor.basic_info.poll_deadline.tooltip') }}
                </x-slot:tooltip>
                {{ __('pages/poll-editor.basic_info.poll_deadline.label') }}
            </x-ui.form.input>
        </div>



        @guest
            {{-- Informace o autorovi --}}
            @if (!$pollIndex)
                <x-pages.poll-editor.author-info-section />
            @endif
        @endguest

    </div>


</x-ui.card>
