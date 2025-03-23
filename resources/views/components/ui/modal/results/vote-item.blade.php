@props([
    /** @var \mixed */
    'timeOptionVote',
    /** @var \string[] */
    'pref'
])

<div class="voting-card-{{ $pref }} d-flex justify-content-between p-3">
    <div> {{ $slot }}</div>
    <div><img class="p-1"
              src="{{ asset('icons/' . $pref . '.svg') }}"
              alt="{{ $pref }}">
    </div>
</div>
