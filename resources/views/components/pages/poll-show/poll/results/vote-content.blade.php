@props(['vote'])

<div class="tw:mt-2">
    <div x-show="open" class="tw:rounded-box tw:bg-gray-400/10">
        @foreach($vote->timeOptions ?? []  as $option)
            <div class="overflow-hidden">
                <div class="tw:flex tw:justify-between tw:p-4">
                    <div>
                        <div class="tw:text-md tw:font-medium tw:mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                        <div class="tw:text-base-content tw:text-xs">
                            @if($option->timeOption->text)
                                <span>{{ $option->timeOption->text }}</span>
                            @else
                                <div class="tw:flex items-center tw:text-gray-600">
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
                <div class="tw:flex tw:justify-between tw:items-center tw:p-3 voting-card-{{$option->preference}}">
                    <div class="tw:flex flex-column">
                        <div class="tw:font-bold tw:mb-1">{{ $option->questionOption->pollQuestion->text }}</div>
                        <div class="tw:text-gray-600">
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
