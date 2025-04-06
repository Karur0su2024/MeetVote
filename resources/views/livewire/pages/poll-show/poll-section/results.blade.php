{{--

TODO: Přidat souhrn výsledků sem, pomocí karet
TODO: Přidat řádek s odpovědí uživatele, pokud už odpověděl
TODO: Sloužit s modalem resources/views/livewire/modals/poll/choose-final-options.blade.php
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div class="p-4">

    <div class="row">


        <div class="col-md-6">
            <h3>
                Your vote
            </h3>

            @if($userVote)
                <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
            @else
                You have not voted yet.
            @endif

        </div>

        <div class="col-md-6">
            <h3>
                All votes
            </h3>

            @foreach($votes as $vote)

                <x-ui.button size="sm"
                             color="outline-secondary"
                             wire:click="openVoteModal({{ $vote }})">
                    {{ $vote->voter_name }}
                </x-ui.button>

            @endforeach

        </div>
    </div>

    <x-pages.poll-show.poll.results.pick-results-form :results="$results"/>

</div>
