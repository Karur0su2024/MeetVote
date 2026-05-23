@props(['vote'])

<div class="mt-2">
    <div x-show="open" class="rounded-box bg-gray-400/10">
        @foreach($vote->timeOptions ?? []  as $option)
            <div class="overflow-hidden">
                <div class="flex justify-between p-4">
                    <div>
                        <div class="text-md font-medium mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                        <div class="text-base-content text-xs">
                            @if($option->timeOption->text)
                                <span>{{ $option->timeOption->text }}</span>
                            @else
                                <div class="flex items-center text-gray-600">
                                    <span>{{ Carbon\Carbon::parse($option->timeOption->start)->format('H:i') }} - {{ Carbon\Carbon::parse( $option->timeOption->end)->format('H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div>
                        <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                             alt="Preference: {{ $option->preference }}"
                             width="30" height="30">
                    </div>
                </div>
            </div>
        @endforeach
        @foreach($vote->questionOptions ?? [] as $option)
            <div class="overflow-hidden">
                <div class="flex justify-between items-center p-3 voting-card-{{$option->preference}}">
                    <div class="flex flex-column">
                        <div class="font-bold mb-1">{{ $option->questionOption->pollQuestion->text }}</div>
                        <div class="text-gray-600">
                            {{ $option->questionOption->text }}
                        </div>
                    </div>

                    <div>
                        <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                             alt="Preference: {{ $option->preference }}"
                             width="30" height="30">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
