{{-- <li>
    <a class="dropdown-item py-1 {{ $class ?? '' }}" href="#"
        onclick="openModal('modals.poll.{{ $modalName }}', '{{ $id }}')">
        {{ $slot }}
    </a>
</li> --}}


<li>
    <a class="dropdown-item py-1 {{ $class ?? '' }}" href="#"
        wire:click="openModal('modals.poll.{{ $modalName }}', '{{ $id }}')">
        {{ $slot }}
    </a>
</li>
