@props([
    'tooltip'
])

<div class="tw-tooltip" data-tip="{{ $tooltip ?? '' }} {{ $slot }}">
    <i class="bi bi-question-circle-fill small">
    </i>
</div>

