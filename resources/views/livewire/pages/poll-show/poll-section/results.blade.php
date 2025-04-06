{{--

TODO: Přidat souhrn výsledků sem, pomocí karet
TODO: Přidat řádek s odpovědí uživatele, pokud už odpověděl
TODO: Sloužit s modalem resources/views/livewire/modals/poll/choose-final-options.blade.php
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div class="p-4">

    <div>
        <h3>
            Your vote
        </h3>

        {{--

        TODO: Přidat řádek s odpovědí uživatele, pokud už odpověděl
        TODO: Pokud nehlasoval, tak přidat tlačítko pro hlasování, které ho přesměruje na hlasování

        --}}

    </div>

    <div class="mt-4">
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


        {{--

        TODO: Přidat tlačítka se jmeny uživatelů, kteří hlasovali
        TODO: Ty otevřou modální okno s odpovědí uživatele

        --}}

    </div>

    <x-pages.poll-show.poll.results.pick-results-form :results="$results"/>

</div>
