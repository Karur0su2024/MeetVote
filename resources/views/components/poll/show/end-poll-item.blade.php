@props(['option', 'optionIndex'])

@php

use Carbon\Carbon;

$optionText = $option['date'];

if (!empty($option['content']['start'])) {
    $start = $option['content']['start'];
    $end = $option['content']['end'];
    $optionText .= " ({$start} - {$end})";
} else {
    $optionText .= " - " . ($option['content']['text']);
}

@endphp

<li class="list-group-item d-flex justify-content-between align-items-center">
    <label for="timeOption_{{ $option['id'] }}" class="w-100 d-flex justify-content-between align-items-center mb-0">
        <span>{{ $optionText }}</span>
        <span>{{ $option['score'] }}</span>
        <input class="form-check-input ms-2" type="radio" value="{{ $optionIndex }}" wire:model='selected.time_option'
            name="flexRadioDefault" id="timeOption_{{ $option['id'] }}">
    </label>
</li>
