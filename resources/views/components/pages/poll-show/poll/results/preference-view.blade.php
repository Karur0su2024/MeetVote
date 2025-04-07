@props([
    'preferences'
])

<div class="d-flex align-items-center justify-content-between gap-4">
    @foreach($preferences as $preferenceName => $preference)
        <div class="align-items-center ">
            <img src="{{ asset('icons/' . $preferenceName . '.svg') }}" alt="{{ $preferenceName  }}"
                 data-bs-toggle="tooltip" data-bs-placement="top"
                 data-bs-html="true"
                 data-bs-title="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
            {{ count($preference) }}
        </div>

    @endforeach
</div>
