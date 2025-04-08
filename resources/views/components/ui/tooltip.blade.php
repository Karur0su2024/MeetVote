@props([
    /** @var \mixed */
    'tooltip'
])

<i class="bi bi-question-circle-fill small"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   data-bs-title="{{ $tooltip ?? '' }} {{ $slot }}">
</i>
