@props([
    'preferences',
    'score' => 0
])

<div class="tw:flex tw:justify-between g-3 tw:text-center">
    <div class="tw:tooltip" data-tip="Total score">
        <div class="tw:flex tw:gap-3 tw:p-2 tw:bg-gray-100/10 tw:text-lg tw:rounded-md">
            <x-ui.icon name="check-square" />
            {{ $score }}
        </div>
    </div>

    @foreach($preferences ?? [] as $preferenceName => $preference)
        <div class="tw:tooltip"
             data-tip="{{ count($preference) !== 0 ? implode('<br>', array_slice($preference, 0, 10)) : 'No votes' }}">
            <div class="tw:flex tw:gap-3 tw:p-2 tw:bg-gray-100/10 tw:text-lg tw:rounded-md">
                <img src="{{ asset('icons/' . $preferenceName . '.svg') }}"
                     alt="{{ $preferenceName  }}" class="me-2">
                {{ count($preference) }}
            </div>
        </div>
    @endforeach

</div>
