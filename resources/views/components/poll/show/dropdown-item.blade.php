@props(['type' => 'dark', 'modalName', 'id'])

<li>
    <a class="dropdown-item py-1 text-{{ $type }}" href="#"
        onclick="openModal('modals.poll.{{ $modalName }}', '{{ $id }}')">
        {{ $slot }}
    </a>
</li>
