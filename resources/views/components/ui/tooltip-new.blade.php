@props([
    'size' => 'md'
])

<div class="tooltip" data-tip="{{ $slot }}">
    <i class="bi bi-info-circle text-{{ $size }}"></i>
</div>
