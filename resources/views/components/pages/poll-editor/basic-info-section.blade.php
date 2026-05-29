@php

    $timezonesWithNames = [];

    foreach($timezones as $timezone){
        $timezonesWithNames[] = [
            'id' => $timezone,
            'name' => $timezone . ' (' . now()->setTimezone($timezone)->format('P') . ')'];
    }
    /*$timezonesWithNames = [
        'id' => $timezones,
        'name' => array_map(function ($timezone) {
            return now()->setTimezone($timezone)->format('P');
        }, $timezones)
    ];*/
@endphp


<x-ui.card>
    <x-ui.text.title-lg>
        {{ __('pages/poll-editor.basic_info.section.poll') }}
    </x-ui.text.title-lg>

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
                   icon="o-globe-europe-africa"/>
    @guest
        {{-- Informace o autorovi --}}
        @if (!$pollIndex)
            <x-pages.poll-editor.author-info-section/>
        @endif
    @endguest

</x-ui.card>
