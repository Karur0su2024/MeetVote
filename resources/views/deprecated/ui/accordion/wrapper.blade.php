@props([
    'flush' => false,
])

<div class="accordion {{ $flush ? 'accordion-flush' : '' }}" {{ $attributes }}>
    {{ $slot }}
</div>
