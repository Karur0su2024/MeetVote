@props([
    'formMessage' => '',
    'color' => 'danger',
    'margin' => 'mb-3',
    'type' => 'form' // form nebo flash
])


<div wire:loading.remove>
    @if($type === 'form')
        @error($formMessage)
            <span class="text-{{ $color }} {{ $margin }}">
                <x-ui.bi name="exclamation-triangle" />
                {{ $message }}</span>
        @enderror
    @endif

    @if($type === 'flash')
        @if(session($formMessage))
            <span class="text-{{ $color }} {{ $margin }}">
                <x-ui.bi name="exclamation-triangle" />
                {{ session($formMessage) }}</span>
        @endif
    @endif

</div>
