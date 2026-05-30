@props([
    'title' => null
    ])

<div class="flex flex-col gap-1">
    <div class="card shadow-sm p-4 bg-base-100 flex text-left {{ $attributes->get("class") }}" {{ $attributes }}>
        {{ $title }}
    </div>
    <div class="card shadow-sm p-4 bg-base-100 flex flex-col gap-3 text-left {{ $attributes->get("class") }}" {{ $attributes }}>
        {{ $slot }}
    </div>
</div>
