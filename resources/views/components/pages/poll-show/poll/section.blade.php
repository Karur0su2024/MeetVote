@push('scripts')
    <script>
        Livewire.on('show-voting-section', () => {
            window.dispatchEvent(new CustomEvent('change-section'));
        });
    </script>
@endpush

<div x-data="{mode: 'Results'}"

    @change-section.window="mode = 'Voting'">

    <x-ui.card body-padding="0" collapsable>

        <x-slot:header>
            {{ __('pages/poll-show.voting.title') }}
        </x-slot:header>

        <x-slot:headerRight>

            <x-ui.button color="outline-secondary"
                         x-text="mode"
                         @click="mode = mode === 'Results' ? 'Voting' : 'Results'">
            </x-ui.button>
        </x-slot:headerRight>

        <x-slot:body>
            <div>
                <div x-show="mode === 'Voting'">
                    <livewire:pages.poll-show.poll-section.voting :poll="$poll" />
                </div>
                <div x-show="mode === 'Results'">
                    <livewire:pages.poll-show.poll-section.results :poll="$poll" />
                </div>
            </div>
        </x-slot:body>
    </x-ui.card>

</div>
