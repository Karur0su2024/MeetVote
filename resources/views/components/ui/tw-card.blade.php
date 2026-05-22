@props([
    'title' => '', // Title of the card

])

<div class="tw:card tw:bg-base-100/80 tw:shadow-md tw:rounded-lg tw:text-start {{ $attributes->get('class') }}" {{ $attributes }}>
    <div class="tw:card-body">
        <div class="tw:flex">
            <div class="tw:grow">
                <h2 class="tw:mb-1 tw:text-2xl">{{ $title }}</h2>
            </div>
            <div class="tw:flex tw:gap-2 tw:items-center">
                {{ $headerRight ?? '' }}
            </div>
        </div>
        {{ $slot }}
    </div>
</div>

