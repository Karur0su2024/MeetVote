{{--

TODO: Přejmenovat tuhle sekci na něco rozumnějšího, protože nazývat tohle voting-section je naprd

--}}


<div x-data="{ mode: 'Results'}">

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
                    {{--
                        TODO: Udělat samostatnou Livewire komponentu pro voting
                    --}}

                    <livewire:pages.poll-show.poll-section.voting :poll="$poll" />
                </div>
                <div x-show="mode === 'Results'">
                    <livewire:pages.poll-show.poll-section.results :poll="$poll" />
                </div>
            </div>
        </x-slot:body>
    </x-ui.card>

</div>
