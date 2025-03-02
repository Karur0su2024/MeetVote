@props([
    'dateIndex', // Index aktuálního data
    'date', // Data obsahující možnosti (textové nebo časové)
])

<div class="card">


    <div class="card-header d-flex justify-content-between align-items-center">
        <!-- Zobrazení data -->
        <strong>{{ $dateIndex }}</strong>
        <button type="button" wire:click="removeDate('{{ is_array($date) ? $date['date'] ?? '' : $date }}')"
            class="btn btn-sm btn-danger">X</button>
    </div>

    <div class="card-body">

        @foreach ($date['options'] as $optionIndex => $option)
            @if ($option['type'] == 'text')

                <!-- Zobrazení textové možnosti -->
                <x-poll.form.time-option-text :index="'{{ $dateIndex }}'" :timeIndex="$optionIndex" />
            @else
                <!-- Zobrazení časového intervalu -->
                <x-poll.form.time-option-range :index="'{{ $dateIndex }}'" :timeIndex="$optionIndex" />
            @endif
        @endforeach

        <!-- Tlačítka pro přidání nové možnosti (časové nebo textové) -->
        <div class="d-flex align-items-center gap-2 mt-3">
            {{ $dateIndex }}
            <button type="button" wire:click="addDateOption({{ $dateIndex }}, 'time')" class="btn btn-primary">
                Přidat časovou možnost
            </button>
            <button type="button" wire:click="addDateOption({{ $dateIndex }}, 'text')" class="btn btn-secondary">
                Přidat textovou možnost
            </button>
        </div>
    </div>


</div>
