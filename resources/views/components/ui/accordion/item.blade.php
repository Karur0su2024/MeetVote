@props([
    'id' => Str::random(6),
    'opened' => false,
])

<div class="accordion-item"  wire:ignore>
    <h2 class="accordion-header">
        <button class="accordion-button fs-{{ $header->attributes->get('fs') ?? '6' }}"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordion-collapse-{{ $id }}"
                aria-expanded="true"
                aria-controls="accordion-collapse-{{ $id }}">
            <div class="d-flex w-100">
                <div class="d-flex flex-column">
                    {{ $header }}
                </div>
            </div>
        </button>
    </h2>

    <div id="accordion-collapse-{{ $id }}" class="accordion-collapse collapse {{ $opened ? 'show' : '' }}"  wire:ignore>
        <div class="accordion-body p-0">
            {{ $body }}
        </div>
    </div>
</div>
