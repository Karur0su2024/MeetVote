@props([
    'headerSize' => '2',
    'footerFlex' => false,
    'collapsable' => false,
    'headerHidden' => false,
])

<div class="card shadow-sm rounded-3 mb-4 {{ $attributes->get('class') }}" {{ $attributes }} x-data="{ show: true }" x-transition>
    @if(!$headerHidden)
        <div class="card-header py-3 text-start">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="mb-0 fs-{{$headerSize}} d-flex gap-3 align-items-center">{{ $header ?? '' }}
                        @if ($tooltip ?? null)
                            <small class="mb-0">
                                <x-ui.tooltip :tooltip="$tooltip" />
                            </small>
                        @endif
                    </h2>
                </div>
                <div class="d-flex gap-3 float-end justify-content-end">
                    {{ $headerRight ?? '' }}
                    @if($collapsable)
                        <x-ui.button color="outline-secondary"
                                     @click="show = !show">
                            <i class="bi bi-eye"></i>
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="card-body text-start p-{{ $bodyPadding ?? 4 }} {{ $bodyClass ?? '' }}"
         x-show="show" x-collapse>
        {{ $body ?? '' }}
        {{ $slot }}
    </div>
    @if ($footer ?? null)
        <div class="card-footer
        {{ $footerFlex ? 'd-flex' : '' }}
        d-grid gap-2 text-start
        p-{{ $footerPadding ?? 2 }}
        {{ $footerClass ?? '' }}"
        >
            {{ $footer }}
        </div>
    @endif
</div>
