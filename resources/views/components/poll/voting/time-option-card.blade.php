@props(['poll'])
@php
    $prefValues = [
        '2' =>  'yes',
        '1' =>  'maybe',
        '0' =>  'none',
        '-1' => 'no',
    ];
@endphp

<div
        {{ $attributes->class(['card card-sharp voting-card border-start-0 border-end-0 p-3 transition-all']) }}
        :class="'voting-card-' + timeOption.picked_preference">
    <div class="card-body voting-card-body">
        <div class="d-flex justify-content-between align-items-center">

            {{-- Obsah možnosti --}}
            <div class="me-2 w-25">

            </div>

            {{-- Skóre možnosti --}}
            <div class="d-flex flex-column align-items-center px-2 py-1 me-2 w-50">

            </div>

            {{-- Výběr preference --}}
            <div>

            </div>
        </div>
    </div>
</div>
