<div class="flex items-center gap-3 p-2">
    <img class="w-6 h-6" src="{{ asset('icons/' . $name . '.svg') }}" alt="{{ $name }}">
    <p class="m-0 font-bold">{{ __('pages/poll-show.voting.preferences.' . $name ) }} ({{ $value }})</p>
</div>
