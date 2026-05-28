@php
    $timezonesWithNames = [
        'id' => $timezones,
        'name' => array_map(function ($timezone) {
            return now()->setTimezone($timezone)->format('P');
        }, $timezones)
    ];

@endphp


<x-ui.card>
    <h3 class="text-xl font-semibold">
        {{ __('pages/poll-editor.basic_info.section.poll') }}
    </h3>
    <x-mary-input
        id="title"
        wire:model="form.title"
        type="text"
        label="{{ __('pages/poll-editor.basic_info.poll_title.label') }}"
        placeholder="{{ __('pages/poll-editor.basic_info.poll_title.placeholder') }}"/>

    {{-- Popis ankety --}}
    <x-mary-textarea
        id="description"
        wire:model="form.description"
        label="{{ __('pages/poll-editor.basic_info.poll_description.label') }}"
        placeholder="{{ __('pages/poll-editor.basic_info.poll_description.placeholder') }}"/>

    {{-- Deadline ankety --}}
    <x-mary-datetime
        id="deadline"
        label="{{ __('pages/poll-editor.basic_info.poll_deadline.label') }}"
        wire:model="form.deadline"
        type="date"/>
    <x-slot:tooltip>
        {{ __('pages/poll-editor.basic_info.poll_deadline.tooltip') }}
    </x-slot:tooltip>

    <x-mary-select label="{{ __('pages/poll-editor.basic_info.poll_timezone.label') }}"
                   wire:model="form.timezone"
                   id="timezone"
                   :options="$timezonesWithNames"
                   icon="o-user"/>

    <fieldset class="fieldset mb-2" x-data="{ timezone: @entangle('form.timezone') }"
              x-init="timezone = timezone ?? Intl.DateTimeFormat().resolvedOptions().timeZone">
        <label class="fieldset-legend pb-1">
            {{ __('pages/poll-editor.basic_info.poll_timezone.label') }}
        </label>

        <select class="select w-full" wire:model="form.timezone" id="timezone">
            @foreach($timezones as $timezone)
                <option value="{{ $timezone }}">{{$timezone}} ({{ now()->setTimezone($timezone)->format('P') }})
                </option>
            @endforeach
        </select>

    </fieldset>


    @guest
        {{-- Informace o autorovi --}}
        @if (!$pollIndex)
            <x-pages.poll-editor.author-info-section/>
        @endif
    @endguest

</x-ui.card>
