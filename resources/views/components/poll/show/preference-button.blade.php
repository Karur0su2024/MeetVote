@props(['optionIndex', 'questionIndex' => null, 'pickedPreference' => 0])

@php
    $preferenceValues =
        $questionIndex === null
            ? [
                '0' => [
                    'text' => 'none',
                    'next' => 2,
                ],
                '2' => [
                    'text' => 'yes',
                    'next' => 1,
                ],
                '1' => [
                    'text' => 'maybe',
                    'next' => -1,
                ],
                '-1' => [
                    'text' => 'no',
                    'next' => 0,
                ],
            ]
            : [
                '0' => [
                    'text' => 'none',
                    'next' => 1,
                ],
                '1' => [
                    'text' => 'yes',
                    'next' => 0,
                ],
            ];

@endphp
<button class="btn btn-outline-vote btn-outline-vote-{{ $preferenceValues[$pickedPreference]['text'] }}
    d-flex align-items-center"
    type="button"
    wire:click="changePreference('{{ $questionIndex }}', '{{ $optionIndex }}', '{{ $preferenceValues[$pickedPreference]['next'] }}')">
    <img class="p-1" src="{{ asset('icons/' . $preferenceValues[$pickedPreference]['text'] . '.svg') }}"
        alt="Preference">

</button>
