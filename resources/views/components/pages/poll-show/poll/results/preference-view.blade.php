@props([
    'preferences',
    'score' => 0
])

<div class="flex justify-between g-3 text-center">
    <div class="tooltip" data-tip="Total score">
        <div class="flex gap-3 p-2 bg-gray-100/10 text-lg rounded-md">
            <x-ui.icon name="check-square" />
            {{ $score }}
        </div>
    </div>

    @foreach($preferences ?? [] as $preferenceName => $preference)
        <div class="tooltip"
             data-tip="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
            <div class="flex gap-3 p-2 bg-gray-100/10 text-lg rounded-md">
                <img src="{{ asset('icons/' . $preferenceName . '.svg') }}"
                     alt="{{ $preferenceName  }}" class="me-2">
                {{ count($preference) }}
            </div>
        </div>
    @endforeach

</div>
