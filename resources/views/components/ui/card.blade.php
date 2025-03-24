@props([
    'headerSize' => '2',
    'collapsable' => false,
])

<div class="card shadow rounded-3 mb-4 {{ $attributes->get('class') }}" {{ $attributes }} x-data="{ show: true }">
    <div class="card-header py-3 text-start">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="mb-0 fs-{{$headerSize}} d-flex gap-3 align-items-center">{{ $header ?? '' }}
                    @if ($tooltip ?? null)
                        <small class="mb-0">
                            <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                               data-bs-title="{{ $tooltip }}"></i>
                        </small>
                    @endif
                </h2>
            </div>
            <div class="mb-0 d-flex gap-3 align-items-center">
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
    <div class="card-body text-start p-{{ $bodyPadding ?? 4 }} {{ $bodyClass ?? '' }}" x-show="show">
        {{ $slot }}
    </div>
    @if ($footer ?? null)
        <div class="card-footer d-grid gap-2 text-start p-{{ $footerPadding ?? 2 }} {{ $footerClass ?? '' }}">
            {{ $footer }}
        </div>
    @endif
</div>
