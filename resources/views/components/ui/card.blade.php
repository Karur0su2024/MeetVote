@props([
    'headerSize' => 'h2',
])

<div class="card shadow rounded-3 mb-4 {{ $attributes->get('class') }}">
    <div class="card-header py-3 text-start">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <{{ $headerSize }} class="mb-0">{{ $header ?? '' }}</{{ $headerSize }}>
            </div>
            <div>
                <h2 class="mb-0">
                    {{ $headerRight ?? '' }}
                    @if ($tooltip ?? null)
                        <h2 class="mb-0">
                            <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                               data-bs-title="{{ $tooltip }}"></i>
                        </h2>
                    @endif
                </h2>
            </div>



        </div>
    </div>
    <div class="card-body text-start p-{{ $bodyPadding ?? 4 }} {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>
    @if ($footer ?? null)
        <div class="card-footer d-grid gap-2 text-start p-{{ $footerPadding ?? 2 }} {{ $footerClass ?? '' }}">
            {{ $footer }}
        </div>
    @endif
</div>
