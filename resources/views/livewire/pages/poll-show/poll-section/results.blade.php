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

    <div class="mt-4">
        <h3>
            Choose results
        </h3>

        <x-ui.button>
            Insert into event form
        </x-ui.button>

        <div>
            <h4 class="mb-3 mt-5">Time options</h4>
            <div class="row g-3">
                @foreach($results['timeOptions']['options'] as $option)
                    <div class="col-md-6">
                        <x-pages.poll-show.poll.results.option-card>
                            <x-slot:content>
                                <p class="fs-5 fw-bold">{{ $option['date_formatted'] }}</p>
                                <p class="card-text text-muted">{{ $option['full_content'] }}</p>
                            </x-slot:content>
                            <x-slot:score>
                                <span class="badge bg-primary fs-5">{{ $option['score'] }}</span>
                            </x-slot:score>
                        </x-pages.poll-show.poll.results.option-card>
                    </div>
                @endforeach
            </div>
        </div>


        @foreach($results['questions'] as $question)
            <div class="mt-3">
                <h4 class="mb-3">{{ $question['text'] }}</h4>
                <div class="row g-3">
                    @foreach($question['options'] as $option)
                        <div class="col-md-6">
                            <x-pages.poll-show.poll.results.option-card>
                                <x-slot:content>
                                    <p>{{ $option['text'] }}</p>
                                </x-slot:content>
                                <x-slot:score>
                                    <span class="badge bg-primary">{{ $option['score'] }}</span>
                                </x-slot:score>
                            </x-pages.poll-show.poll.results.option-card>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</div>
