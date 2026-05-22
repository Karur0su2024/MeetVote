@props([
    'title' => '', // Title of the card

])

<div class="tw-card tw-bg-base-100 tw-shadow-md tw-rounded-lg tw-mb-4 tw-text-start {{ $attributes->get('class') }}" {{ $attributes }}>
    <div class="tw-card-body">
        <div class="tw-flex tw-flex-row tw-items-center">
            <div class="tw-grow">
                <h2 class="tw-mb-1 text-break tw-text-2xl">{{ $title }}</h2>
            </div>
            <div class="tw-flex tw-flex-row tw-gap-2">
                {{ $headerRight ?? '' }}
            </div>
        </div>
        {{ $slot }}
    </div>
</div>

