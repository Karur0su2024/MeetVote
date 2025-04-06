<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ $vote->voter_name ?? 'anonymous' }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif
        </div>
        <div class="text-muted small">
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </div>


        <div class="d-flex gap-2 p-2 my-2">
            @can('delete', $vote)
                <x-ui.button color="outline-danger"
                             wire:click="deleteVote({{ $vote->id }})">
                    <x-ui.icon name="trash"/>
                    {{ __('ui/modals.results.buttons.delete_vote') }}
                </x-ui.button>
            @endcan
            @can('edit', $vote)
                <x-ui.button color="outline-secondary"
                             wire:click="loadVote({{ $vote->id }})">
                    <x-ui.icon name="pencil"/>
                    {{ __('ui/modals.results.buttons.load_vote') }}
                </x-ui.button>
            @endcan
        </div>
        @foreach($vote->timeOptions ?? []  as $option)
            <div class="border-0 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center p-3 voting-card-{{$option->preference}}">
                    <div class="d-flex flex-column">
                        <div class="fw-bold mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                        <div class="text-muted small">
                            @if($option->timeOption->text)
                                <span>{{ $option->timeOption->text }}</span>
                            @else
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock me-1"></i>
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
