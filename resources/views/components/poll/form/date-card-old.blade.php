@php
    $day = Carbon\Carbon::parse($dateIndex)->format('F d, Y');
@endphp

<div class="card mb-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{ $header }}
        <!-- Zobrazení data -->
        <strong class="card-title m-0">{{ $day }} </strong>

        <!-- Tlačítko pro odstranění celého data -->
        <button type="button" wire:click="removeDate('{{ $dateIndex }}')" class="btn btn-sm btn-danger">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>



    <div class="card-body p-2">

        {{ $slot }}

        @foreach ($date as $optionIndex => $option)
            @if ($option['type'] == 'text')
                <!-- Zobrazení textové možnosti -->
                <x-poll.form.time-options.text :dateIndex="$dateIndex" :optionIndex="$optionIndex" :exists="isset($option['id'])" />
            @else
                <!-- Zobrazení časového intervalu -->
                <div class="p-2 mb-2 rounded border">
                    <!-- Zobrazení časového intervalu -->
                    <div class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
                        {{-- Pole pro zadání začátku časového intervalu  --}}
                        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.start"
                            class="form-control w-100 w-md-auto">

                        {{-- Pole pro zadání konce časového intervalu --}}
                        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.end"
                            class="form-control w-100 w-md-auto">

                        {{-- Tlačítko pro odstranění časové možnosti --}}
                        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $optionIndex }}')"
                            class="btn btn-danger mx-auto">

                            <i class="bi bi-trash"></i><span class="d-md-none ms-1">Delete</span>
                        </button>
                    </div>

                    {{-- Chybové hlášky pro začátek a konec časového intervalu --}}
                </div>
            @endif
        @endforeach

        <!-- Tlačítka pro přidání nové možnosti (časové nebo textové) -->
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">
            <x-outline-button wireClick="addTimeOption('{{ $dateIndex }}', 'time')" class="w-100 w-md-auto">
                <i class="bi bi-clock me-1"></i> Add time option
            </x-outline-button>

            <x-outline-button wireClick="addTimeOption('{{ $dateIndex }}', 'text')" class="w-100 w-md-auto">
                <i class="bi bi-fonts me-1"></i> Add text option
            </x-outline-button>
        </div>

        @error("form.dates.{$dateIndex}.*")
            <div class="alert alert-danger mt-3 mb-0" role="alert">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
