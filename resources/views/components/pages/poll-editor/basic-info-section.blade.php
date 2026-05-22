<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/poll-editor.basic_info.section.poll') }}
    </x-slot:title>


        <div class="mb-3">

            <x-ui.form.tw-input
                id="title"
                wire:model="form.title"
                type="text"
                placeholder="{{ __('pages/poll-editor.basic_info.poll_title.placeholder') }}">
                <x-slot:label>
                    {{ __('pages/poll-editor.basic_info.poll_title.label') }}
                </x-slot:label>
            </x-ui.form.tw-input>

            {{-- Popis ankety --}}
            <x-ui.form.tw-textbox
                id="description"
                wire:model="form.description"
                placeholder="{{ __('pages/poll-editor.basic_info.poll_description.placeholder') }}">
                {{ __('pages/poll-editor.basic_info.poll_description.label') }}
            </x-ui.form.tw-textbox>

            {{-- Deadline ankety --}}
            <x-ui.form.tw-input
                id="deadline"
                wire:model="form.deadline"
                type="date">
                <x-slot:tooltip>
                    {{ __('pages/poll-editor.basic_info.poll_deadline.tooltip') }}
                </x-slot:tooltip>
                <x-slot:label>
                    {{ __('pages/poll-editor.basic_info.poll_deadline.label') }}
                </x-slot:label>
            </x-ui.form.tw-input>

            <fieldset class="tw-fieldset mb-2" x-data="{ timezone: @entangle('form.timezone') }" x-init="timezone = timezone ?? Intl.DateTimeFormat().resolvedOptions().timeZone">
                <label class="tw-fieldset-legend pb-1">
                    {{ __('pages/poll-editor.basic_info.poll_timezone.label') }}
                </label>

                <select class="tw-select w-100" wire:model="form.timezone" id="timezone">
                    @foreach($timezones as $timezone)
                        <option value="{{ $timezone }}">{{$timezone}} ({{ now()->setTimezone($timezone)->format('P') }})</option>
                    @endforeach
                </select>

            </fieldset>



        </div>



        @guest
            {{-- Informace o autorovi --}}
            @if (!$pollIndex)
                <x-pages.poll-editor.author-info-section />
            @endif
        @endguest

</x-ui.tw-card>
