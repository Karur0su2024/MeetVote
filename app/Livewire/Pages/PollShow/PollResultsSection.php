<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Livewire\Component;

class PollResultsSection extends Component
{
    use CanOpenModals;

    protected PollResultsService $pollResultsService;

    public $poll;

    public $pollResults = [];

    public function boot(PollResultsService $pollResultsService){
        $this->pollResultsService = $pollResultsService;
    }

    public function mount($pollIndex){
        $this->poll = Poll::find($pollIndex);
        $this->pollResults = $this->pollResultsService->getResults($this->poll);
    }

    public function render()
    {
        return view('livewire.pages.poll-show.poll-results-section');
    }
}
