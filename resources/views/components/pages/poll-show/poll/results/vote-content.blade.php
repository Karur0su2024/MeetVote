@props(['vote'])

<div>
    <div class="d-flex gap-2 my-2">

    </div>
    <div x-show="open" class="border rounded">
        @foreach($vote->timeOptions ?? []  as $option)
            <div class="overflow-hidden">
                <div class="d-flex justify-content-between align-items-center p-3 voting-card-{{$option->preference}}">
                    <div class="d-flex flex-column">
                        <div
                            class="fw-bold mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                        <div class="text-muted small">
                            @if($option->timeOption->text)
                                <span>{{ $option->timeOption->text }}</span>
                            @else
                                <div class="d-flex align-items-center">
                                    <span>{{ $option->timeOption->start }} - {{ $option->timeOption->end }}</span>
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
            <div class="border-0 overflow-hidden">
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
