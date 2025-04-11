@push('scripts')
    <script>
        Livewire.on('show-voting-section', () => {
            window.dispatchEvent(new CustomEvent('change-section'));
        });
    </script>
@endpush

<div x-data="{
    mode: '{{ $poll->isActive() ? 'Voting' : 'Results' }}'
}"
    @change-section.window="mode = 'Voting'">

    <x-ui.card header-hidden>

        <x-slot:body-header>
            <h2 x-text="mode"></h2>
            <div>
                @if($poll->isActive())
                    <x-ui.button color="outline-secondary"
                                 x-text="mode === 'Results' ? 'Show voting options' : 'Show results'"
                                 @click="mode = mode === 'Results' ? 'Voting' : 'Results'">
                    </x-ui.button>

                @endif
            </div>

        </x-slot:body-header>

        <x-slot:body>
            <div>


                @if($poll->isActive())
                    @if($poll->deadline)
                        <x-ui.alert type="info">
                          {{ (int) \Carbon\Carbon::parse($poll->deadline)->diffInDays(now(), $poll->deadline) }} days left to vote!
                        </x-ui.alert>
                    @endif
                    <div x-show="mode === 'Voting'">
                        <livewire:pages.poll-show.poll-section.voting :poll="$poll" />
                    </div>
                @else
                    <x-ui.alert type="warning">
                        Poll has ended! You can no longer vote.
                    </x-ui.alert>
                @endif
                <div x-show="mode === 'Results'">
                    <livewire:pages.poll-show.poll-section.results :poll="$poll" />
                </div>
            </div>
        </x-slot:body>
    </x-ui.card>

</div>
