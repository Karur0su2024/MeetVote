@props(['vote'])

<div class="flex flex-col mt-3 gap-1">
    @foreach($vote->timeOptions ?? []  as $option)
        <div class="bg-base-200 flex flex-row p-2 border-2 border-dotted rounded">
            <div class="flex-1">
                <p class="text-md">
                    {{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}
                </p>
                <p class="text-sm">
                    @if($option->timeOption->text)
                        <span>{{ $option->timeOption->text }}</span>
                    @else
                        <span>{{ Carbon\Carbon::parse($option->timeOption->start)->format('H:i') }} - {{ Carbon\Carbon::parse( $option->timeOption->end)->format('H:i') }}</span>
                    @endif
                </p>

            </div>
            <div>
                <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                     alt="Preference: {{ $option->preference }}"
                     width="26" height="26">
            </div>
        </div>

    @endforeach

    @foreach($vote->questionOptions ?? [] as $option)
        <div class="bg-base-200 flex flex-row p-2 border-2 border-dotted rounded">
            <div class="flex-1">
                <p class="text-md">
                    {{ $option->questionOption->pollQuestion->text }}
                </p>
                <p class="text-sm">
                    {{ $option->questionOption->text }}
                </p>

            </div>
            <div>
                <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                     alt="Preference: {{ $option->preference }}"
                     width="26" height="26">
            </div>
        </div>

    @endforeach

</div>
