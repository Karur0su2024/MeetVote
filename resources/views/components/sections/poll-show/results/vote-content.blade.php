@props(['vote'])

@php
    $preferenceIcon = static fn ($preference) => asset("icons/{$preference}.svg");
@endphp

<div class="mt-2">
    <div
        x-show="open"
        x-cloak
        class="rounded-box bg-gray-400/10 divide-y divide-base-300/50 overflow-hidden"
    >
        @foreach($vote->timeOptions ?? [] as $option)
            @php
                $timeOption = $option->timeOption;
                $date = $timeOption?->date
                    ? \Carbon\Carbon::parse($timeOption->date)->format('d. m. Y')
                    : null;
                $start = $timeOption?->start
                    ? \Carbon\Carbon::parse($timeOption->start)->format('H:i')
                    : null;
                $end = $timeOption?->end
                    ? \Carbon\Carbon::parse($timeOption->end)->format('H:i')
                    : null;
            @endphp

            <div class="flex items-center justify-between gap-4 p-4">
                <div class="min-w-0">
                    @if($date)
                        <div class="mb-1 text-md font-medium">
                            {{ $date }}
                        </div>
                    @endif

                    <div class="text-xs text-base-content/70">
                        @if($timeOption?->text)
                            <span>{{ $timeOption->text }}</span>
                        @elseif($start && $end)
                            <span>{{ $start }} – {{ $end }}</span>
                        @else
                            <span class="italic text-base-content/50">
                                Čas není uveden
                            </span>
                        @endif
                    </div>
                </div>

                <img
                    src="{{ $preferenceIcon($option->preference) }}"
                    alt="Preference: {{ $option->preference }}"
                    width="30"
                    height="30"
                    class="shrink-0"
                    loading="lazy"
                >
            </div>
        @endforeach

        @foreach($vote->questionOptions ?? [] as $option)
            <div class="flex items-center justify-between gap-4 p-4 voting-card-{{ $option->preference }}">
                <div class="min-w-0">
                    <div class="mb-1 font-bold">
                        {{ $option->questionOption?->pollQuestion?->text }}
                    </div>

                    <div class="text-sm text-base-content/70">
                        {{ $option->questionOption?->text }}
                    </div>
                </div>

                <img
                    src="{{ $preferenceIcon($option->preference) }}"
                    alt="Preference: {{ $option->preference }}"
                    width="30"
                    height="30"
                    class="shrink-0"
                    loading="lazy"
                >
            </div>
        @endforeach
    </div>
</div>
