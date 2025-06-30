@props([
    'title' => '', // Title of the card

])

<div class="tw-card tw-bg-base-100 w-96 tw-shadow-md tw-rounded-lg tw-mb-4 text-start {{ $attributes->get('class') }}" {{ $attributes }}>
    <div class="tw-card-body">
        <h2 class="card-title mb-1 tw-text-2xl text-break">{{ $title }}</h2>
        {{ $slot }}
    </div>
</div>


{{--<div class="card shadow-mt rounded-3 mb-4 {{ $attributes->get('class') }}" {{ $attributes }} x-data="{ show: true }" x-transition>--}}
{{--    @if(!$headerHidden)--}}
{{--        <div class="card-header py-3 text-start">--}}
{{--            <div class="d-flex align-items-center justify-content-between">--}}
{{--                <div>--}}
{{--                    <h2 class="mb-0 fs-{{$headerSize}} d-flex gap-3 align-items-center">{{ $header ?? '' }}--}}
{{--                        @if ($tooltip ?? null)--}}
{{--                            <small class="mb-0">--}}
{{--                                <x-ui.tooltip :tooltip="$tooltip" />--}}
{{--                            </small>--}}
{{--                        @endif--}}
{{--                    </h2>--}}
{{--                </div>--}}
{{--                <div class="d-flex gap-3 float-end justify-content-end">--}}
{{--                    {{ $headerRight ?? '' }}--}}
{{--                    @if($collapsable)--}}
{{--                        <x-ui.button color="outline-secondary"--}}
{{--                                     @click="show = !show">--}}
{{--                            <i class="bi bi-eye"></i>--}}
{{--                        </x-ui.button>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <div class="card-body text-start {{ $bodyClass ?? '' }}  {{  $body !== null ? $body->attributes->get('class') : '' }}"--}}
{{--         {{ $body !== null ? $body->attributes : '' }}--}}
{{--         x-show="show" x-collapse>--}}
{{--        @if ($bodyHeader ?? null)--}}
{{--            <div class="d-flex justify-content-between align-items-center mb-2">--}}
{{--                {{ $bodyHeader }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        {{ $body ?? '' }}--}}
{{--        {{ $slot }}--}}
{{--    </div>--}}
{{--    @if ($footer ?? null)--}}
{{--        <div class="card-footer--}}
{{--        {{ $footerFlex ? 'd-flex' : '' }}--}}
{{--        d-grid gap-2 text-start--}}
{{--        p-{{ $footerPadding ?? 2 }}--}}
{{--        {{ $footerClass ?? '' }}--}}
{{--        {{ $footer->attributes->get('class') }}"--}}
{{--        >--}}
{{--            {{ $footer }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}
