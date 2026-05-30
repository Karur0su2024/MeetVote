@props([
    'title' => '', // Title of the card

])

<div class="card bg-base-100 shadow-sm rounded-lg text-start {{ $attributes->get('class') }}" {{ $attributes }}>
    <div class="card-body">
        <div class="flex">
            <div class="grow">
                <h2 class="mb-1 text-2xl">{{ $title }}</h2>
            </div>
            <div class="flex gap-2 items-center">
                {{ $headerRight ?? '' }}
            </div>
        </div>
        {{ $slot }}
    </div>
</div>

