@props([
    'color' => 'dark',
    'disabled' => false,
    'modalName' => '',
    'id' => '',
])

<li>
    <a class="dropdown-item py-1 {{ $class ?? '' }} text-{{ $color }}"
       href="#"
        wire:click="openModal('modals.poll.{{ $modalName }}', '{{ $id }}')">
        {{ $slot }}
    </a>
</li>
