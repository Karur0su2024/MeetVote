<x-ui.card header-hidden>
    <x-slot:body-header>
        <h2 class="mb-3">
            {{ __('pages/poll-editor.basic_info.title') }}
        </h2>

    </x-slot:body-header>
    {{-- Hlavička --}}

    <x-slot:body>
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

            <label for="timezone"
                   class="form-label mt-3">
                {{ __('pages/poll-editor.basic_info.poll_timezone.label') }}
            </label>
            <div x-data="{ timezone: @entangle('form.timezone') }" x-init="timezone = Intl.DateTimeFormat().resolvedOptions().timeZone">

                <select class="form-control" wire:model="form.timezone" id="timezone">
                    @foreach($timezones as $timezone)
                        <option value="{{ $timezone }}">{{$timezone}} ({{ now()->setTimezone($timezone)->format('P') }})</option>
                    @endforeach
                </select>
            </div>


        </div>



        @guest
            {{-- Informace o autorovi --}}
            @if (!$pollIndex)
                <x-pages.poll-editor.author-info-section />
            @endif
        @endguest

    </x-slot:body>
</x-ui.card>
