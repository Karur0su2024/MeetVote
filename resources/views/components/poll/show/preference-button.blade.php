@props([
    'option', 
    'questionIndex' => null
])

@php
    // Definice preferencí na základě otázky
    $preferences = $questionIndex === null ? [
        0 => ['text' => 'none'],
        1 => ['text' => 'maybe'],
        2 => ['text' => 'yes'],
        -1 => ['text' => 'no'],
    ] : [
        0 => ['text' => 'none'],
        2 => ['text' => 'yes'],
    ];

    $chosenPreference = $option['chosen_preference'] ?? 0;
    $preferenceText = $preferences[$chosenPreference]['text'];

@endphp
<button class="btn btn-outline-vote-{{ $preferenceText }} d-flex align-items-center"
    wire:click="changePreference({{ $option['id'] }}, {{ $questionIndex ?? null }})">
    <img class="p-1" src="{{ asset('icons/' . $preferenceText . '.svg') }}"
    alt="Preference">
</button>
