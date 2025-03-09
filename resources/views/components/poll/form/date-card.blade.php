@props([
    'dateIndex', // Index aktuálního data
    'date', // Data obsahující možnosti (textové nebo časové)
])

@php
    $day = Carbon\Carbon::parse($dateIndex)->format('F d, Y');
@endphp

<div class="card mb-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <!-- Zobrazení data -->
        <strong class="card-title m-0">{{ $day }} </strong>

        <!-- Tlačítko pro odstranění celého data -->
        <button type="button" wire:click="removeDate('{{ $dateIndex }}')" class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </div>



    <div class="card-body p-2">
        @foreach ($date as $optionIndex => $option)
            @if ($option['type'] == 'text')
                <!-- Zobrazení textové možnosti -->
                <x-poll.form.time-options.text :dateIndex="$dateIndex" :optionIndex="$optionIndex" :exists="isset($option['id'])" />
            @else
                <!-- Zobrazení časového intervalu -->
                <x-poll.form.time-options.time :dateIndex="$dateIndex" :optionIndex="$optionIndex" :exists="isset($option['id'])" />
            @endif
        @endforeach

        <!-- Tlačítka pro přidání nové možnosti (časové nebo textové) -->
        <div class="d-flex align-items-center gap-2 mt-1">
            <x-outline-button wireClick="addTimeOption('{{ $dateIndex }}', 'time')">
                <i class="bi bi-fonts"></i> Add time option
            </x-outline-button>

            <x-outline-button wireClick="addTimeOption('{{ $dateIndex }}', 'text')">
                <i class="bi bi-fonts"></i> Add text option
            </x-outline-button>
        </div>

        @error("form.dates.{$dateIndex}.*")
            <div class="alert alert-danger mt-3 mb-0" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
