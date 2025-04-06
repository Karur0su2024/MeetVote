{{--

TODO: Přidat souhrn výsledků sem, pomocí karet
TODO: Přidat řádek s odpovědí uživatele, pokud už odpověděl
TODO: Sloužit s modalem resources/views/livewire/modals/poll/choose-final-options.blade.php
IDEA: Přidat nějaký graf pro lepší interpretaci výsledků

--}}
<div class="p-4">

    <div class="row g-3">

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3>
                        Your vote
                    </h3>
                    <div>
                        @if($userVote)
                            <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
                        @else
                            <p class="text-muted">
                                You have not voted yet.
                            </p>

                            <x-ui.button>
                                Add new vote
                            </x-ui.button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h3>All votes</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($votes as $vote)
                            <x-ui.button size="sm"
                                         color="outline-secondary"
                                         wire:click="openVoteModal({{ $vote }})">
                                {{ $vote->voter_name }}
                            </x-ui.button>
                        @empty
                            No votes yet.
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('hasAdminPermissions', $poll)
        <x-pages.poll-show.poll.results.pick-results-form :results="$results"/>
    @else
        <x-pages.poll-show.poll.results.results :results="$results" />
    @endcan

</div>
