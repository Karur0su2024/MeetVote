<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Livewire\Component;

class Results extends Component
{

    use CanOpenModals;


    public $results = [];

    public function mount($poll, PollResultsService $pollResultsService){
        $this->results = $pollResultsService->getResults($poll);
    }


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.results');
    }
}
