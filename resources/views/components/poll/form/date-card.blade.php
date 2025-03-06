@props([
    'dateIndex', // Index aktuálního data
    'date', // Data obsahující možnosti (textové nebo časové)
])

@php
    $day = Carbon\Carbon::parse($dateIndex)->format('F d, Y');

@endphp

<div class="card mb-3">


    <div class="card-header d-flex justify-content-between align-items-center">
        <!-- Zobrazení data -->
        <strong>{{ $day }} </strong>
        <button type="button" wire:click="removeDate('{{ $dateIndex }}')" class="btn btn-sm btn-danger">X</button>
    </div>

    <div class="card-body">

        @foreach ($date['options'] as $optionIndex => $option)
            @if ($option['type'] == 'text')
                <!-- Zobrazení textové možnosti -->
                <x-poll.form.time-option-text :dateIndex="$dateIndex" :timeIndex="$optionIndex" />
            @else
                <!-- Zobrazení časového intervalu -->
                <x-poll.form.time-option-range :dateIndex="$dateIndex" :timeIndex="$optionIndex" />
            @endif
        @endforeach

        <!-- Tlačítka pro přidání nové možnosti (časové nebo textové) -->
        <div class="d-flex align-items-center gap-2 mt-3">
            <button type="button" wire:click="addDateOption('{{ $dateIndex }}', 'time')"
                class="btn btn-outline-secondary">
                Add time option
            </button>
            <button type="button" wire:click="addDateOption('{{ $dateIndex }}', 'text')"
                class="btn btn-outline-secondary">
                Add text option
            </button>
        </div>

        @error("dates.{$dateIndex}.*")
            <div class="alert alert-danger mt-3 mb-0" role="alert">
                {{ $message }}
            </div>
        @enderror


    </div>


</div>
