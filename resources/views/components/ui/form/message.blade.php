@props([
    'formMessage' => '',
    'color' => 'danger',
    'margin' => 'mb-3',
    'type' => 'form' // form nebo flash
])


<div wire:loading.remove>
    @if($type === 'form')
        @error($formMessage)
            <span class="text-{{ $color }} {{ $margin }}">{{ $message }}</span>
        @enderror
    @endif

    @if($type === 'flash')
        @if(session($formMessage))
            <span class="text-{{ $color }} {{ $margin }}">{{ session($formMessage) }}</span>
        @endif
    @endif



</div>
