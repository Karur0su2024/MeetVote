@props([
    'tooltip'
])

<div class="tooltip" data-tip="{{ $tooltip ?? '' }} {{ $slot }}">
    <i class="bi bi-question-circle-fill text-sm"></i>
</div>

