@props(['option', 'optionIndex'])

@php

use Carbon\Carbon;

$optionText = $option['date'];


if($option['start'] != null){


    $start = $option['start'];
    $end = $option['end'];
    // Časová možnost
    $optionText .= ' (' . $start . ' - ' . $end . ')';
} else {
    $optionText .= ' - ' . $option['text'];
}


@endphp

<li class="list-group-item d-flex justify-content-between align-items-center">
    <label for="timeOption_{{ $option['id'] }}" class="w-100 d-flex justify-content-between align-items-center mb-0">
        <span>{{ $optionText }}</span>
        <span>{{ $option['votes'] }}</span>
        <input class="form-check-input ms-2" type="radio" value="{{ $optionIndex }}" wire:model='selectedTimeOption'
            name="flexRadioDefault" id="timeOption_{{ $option['id'] }}">
    </label>
</li>
