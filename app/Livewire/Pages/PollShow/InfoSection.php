<?php

namespace App\Livewire\Pages\PollShow;

use App\Events\PollReopened;
use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use App\Traits\HasVoteControls;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

// Sekce s detaily o anketě
class InfoSection extends Component
{
    use CanOpenModals;
    use HasVoteControls;

    public $poll;

    public $event;

    public bool $myModal1 = false;

    public bool $myModal2 = false;

    public $userVote;

    protected PollResultsService $pollResultsService;

    protected EventService $eventService;

    public $status;

    public $hasEvent;

    public $newDeadline;

    public function rules(): array
    {
        return [
            'newDeadline' => 'nullable|date|after:today', // Uzávěrka ankety
        ];
    }

    public function boot(PollResultsService $pollResultsService, EventService $eventService): void
    {
        $this->pollResultsService = $pollResultsService;
        $this->eventService = $eventService;
    }

    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->userVote = $pollResultsService->getUserVote($this->poll);

        if ($this->poll) {
            $this->event = $this->poll->event()->first();
        }

        $this->hasEvent = $this->poll->event()->exists();
    }

    public function closePoll()
    {

        if (Gate::allows('close', $this->poll)) {
            $this->validate();
            try {
                DB::beginTransaction();
                $this->poll->status = $this->poll->status->toggle();
                $this->poll->deadline = $this->newDeadline;
                $this->poll->save();
                DB::commit();

                PollReopened::dispatchIf(true, $this->poll);

                return redirect()->route('polls.show', ['poll' => $this->poll->public_id])->with('success', __('ui/modals.close_poll.messages.success.poll_status_updated'));
            } catch (\Exception $e) {
                session()->flash('error', __('ui/modals.close_poll.messages.error.closing'));
                DB::rollBack();

                //                dd($e->getMessage());
                return;
            }
        }
    }

    public function deletePoll()
    {
        try {
            $this->poll->delete();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the poll.');

            return;
        }

        return redirect()->route('dashboard');
    }


    public function render()
    {
        return view('livewire.pages.poll-show.info-section');
    }



}
