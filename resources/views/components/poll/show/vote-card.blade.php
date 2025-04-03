@props(['vote'])
@php
    $preferenceValues = [
        '-1' => 'no',
        '0' => 'none',
        '1' => 'maybe',
        '2' => 'yes',
    ];
@endphp

<x-ui.accordion.item>
    <x-slot:header>

    </x-slot:header>
    <x-slot:body>

    </x-slot:body>
</x-ui.accordion.item>
