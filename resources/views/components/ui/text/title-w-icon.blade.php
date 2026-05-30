@props([
    'icon' => null,
    'title' => null,
    'subtitle' => null
])

<div class="flex gap-3 items-center">
    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
        {{ $icon }}
    </div>

    <div>
        <h3 class="text-lg font-semibold">
            {{ $title }}
        </h3>

        <p class="text-sm text-base-content/60">
            {{ $subtitle }}
        </p>

    </div>
</div>
