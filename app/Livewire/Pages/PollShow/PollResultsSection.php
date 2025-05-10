<?php

namespace App\Livewire\Pages\PollShow;

use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use Livewire\Component;

// Nepoužívaná třída
class PollResultsSection extends Component
{
    use CanOpenModals;

    public $poll;

    public $pollResults = [];

    public function mount($pollIndex, PollResultsService $pollResultsService){
        $this->poll = Poll::find($pollIndex);
        $this->pollResults = $pollResultsService->getResults($this->poll);
    }

    public function render()
    {
        return view('livewire.pages.poll-show.poll-results-section');
    }
}
