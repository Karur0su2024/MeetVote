@props(['vote'])

<div class="tw-mt-2">
    <div x-show="open" class="tw-rounded-box tw-bg-base-200">
        @foreach($vote->timeOptions ?? []  as $option)
            <div class="overflow-hidden">
                <div class="d-flex justify-content-between align-items-center tw-p-4">
                    <div class="d-flex flex-column">
                        <div class="tw-text-md tw-font-medium tw-mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                        <div class="tw-text-base-content tw-text-xs">
                            @if($option->timeOption->text)
                                <span>{{ $option->timeOption->text }}</span>
                            @else
                                <div class="d-flex align-items-center">
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
                <div class="d-flex justify-content-between align-items-center p-3 voting-card-{{$option->preference}}">
                    <div class="d-flex flex-column">
                        <div class="fw-bold mb-1">{{ $option->questionOption->pollQuestion->text }}</div>
                        <div class="text-muted small">
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
