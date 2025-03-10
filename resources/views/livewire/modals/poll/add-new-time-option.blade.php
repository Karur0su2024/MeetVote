<div>
    <div class="modal-header">
        <h5 class="modal-title">Add new time option to {{ $poll->title }}</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form wire:submit.prevent="submit">


            {{-- Přepínání časového a textového typu --}}
            <ul class="nav nav-pills mb-3">

                <li class="nav-item">
                    <button type="button" class="nav-link {{ $type == 'time' ? 'active' : '' }}"
                        wire:click="changeType('time')">Time
                        option</a>
                </li>

                <li class="nav-item">
                    <button type="button" class="nav-link {{ $type == 'text' ? 'active' : '' }}"
                        wire:click="changeType('text')">Text
                        option</a>
                </li>
            </ul>

            {{-- Zobrazení data --}}
            <x-input id="date" model="date" type="date" placeholder="Date" mandatory="true">
                Date
            </x-input>


            @if ($type == 'time')
                {{-- Zobrazeno pouze v případě nastaveného typu na time --}}
                <div class="mb-3">

                    {{-- Pole pro zadání začátku časového intervalu  --}}
                    <x-input id="start" model="content.start" type="time" placeholder="Start">
                        Start
                    </x-input>

                    {{-- Pole pro zadání konce časového intervalu --}}
                    <x-input id="end" model="content.end" type="time" placeholder="End">
                        End
                    </x-input>

                </div>
            @else
                {{-- Zobrazeno pouze v případě nastaveného typu na text --}}
                <x-input id="text" model="content.text" type="text" placeholder="Text">
                    Text
                </x-input>
            @endif






            <button type="submit" class="btn btn-primary">Add</button>
            {{-- Chybové hlášky --}}
            @error('error')
                <span class="text-danger ms-3">{{ $message }}</span>
            @enderror

        </form>
    </div>
</div>
