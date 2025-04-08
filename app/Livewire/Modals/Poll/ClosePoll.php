<?php

namespace App\Livewire\Modals\Poll;

use App\Enums\PollStatus;
use App\Events\PollReopened;
use App\Services\PollResultsService;
use Livewire\Component;
use App\Models\Poll;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class ClosePoll extends Component
{
    public $poll;
    public $status;
    protected EventService $eventService;

    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    /**
     * @param $pollId
     * @return void
     */
    public function mount($pollIndex): void
    {
        $this->poll = Poll::find($pollIndex, ['id', 'status']);
        $this->status = $this->poll->status;
    }

    /**
     * Metoda pro zavření hlasování
     *
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Throwable
     */
    public function closePoll()
    {

        if(Gate::allows('close', $this->poll)) {
            try {
                DB::beginTransaction();
                $this->poll->status = $this->poll->status->toggle();
                $this->poll->save();
                DB::commit();

                PollReopened::dispatchIf(true, $this->poll);

                return redirect()->route('polls.show', ['poll' => $this->poll->public_id])->with('success', 'Poll status updated successfully.');
            } catch (\Exception $e) {
                session()->flash('error', 'An error occurred while closing poll.');
                DB::rollBack();
                return;
            }
        }
    }


    public function render()
    {
        return view('livewire.modals.poll.close-poll');
    }

}
