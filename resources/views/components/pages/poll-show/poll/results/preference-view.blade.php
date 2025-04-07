@props([
    'preferences',
    'score'
])

<div class="d-flex align-items-center justify-content-between gap-4">
    @if($score)
        <div class="align-items-center border p-2 px-4 rounded bg-primary text-light fw-bold">
            {{ $score }}
        </div>
    @endif
    @foreach($preferences as $preferenceName => $preference)
        <div class="align-items-center border p-2 rounded"
             data-bs-toggle="tooltip"
             data-bs-placement="top"
             data-bs-html="true"
             data-bs-title="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
            <img src="{{ asset('icons/' . $preferenceName . '.svg') }}"
                 alt="{{ $preferenceName  }}">
            {{ count($preference) }}
        </div>
    @endforeach
</div>
