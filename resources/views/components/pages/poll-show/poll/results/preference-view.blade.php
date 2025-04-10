@props([
    'preferences',
    'score' => 0
])

<div class="row align-items-center g-3">
    <div class="col-md-3 col-6">
        <div class="align-items-center text-center border p-2 px-4 rounded bg-primary text-light fw-bold"
             data-bs-toggle="tooltip"
             data-bs-placement="top"
             data-bs-html="true"
             data-bs-title="Total score">
            {{ $score }}
        </div>
    </div>

    @foreach($preferences ?? [] as $preferenceName => $preference)
        <div class="col-md-3 col-6">
            <div class="align-items-center border p-2 rounded fw-bold"
                 data-bs-toggle="tooltip"
                 data-bs-placement="top"
                 data-bs-html="true"
                 data-bs-title="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
                <img src="{{ asset('icons/' . $preferenceName . '.svg') }}"
                     alt="{{ $preferenceName  }}" class="me-2">
                {{ count($preference) }}
            </div>
        </div>
    @endforeach

</div>
