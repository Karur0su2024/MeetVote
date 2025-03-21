<?php

namespace App\Livewire\Modals\Poll;

use Livewire\Component;
use App\Models\Poll;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exceptions\CriticalErrorException;


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
    public function mount($pollId): void
    {
        $this->poll = Poll::find($pollId, ['id', 'status']);
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
        if($this->checkPollStatus()) {
            return;
        }
        try {
            DB::beginTransaction();
            $this->updateStatus();
            DB::commit();
            return redirect()->route('polls.show', ['poll' => $this->poll->public_id]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while closing poll.');
            DB::rollBack();
            return;
        }

    }

    private function checkPollStatus() {
        if ($this->poll->status !== $this->status) {
            session()->flash('error', 'The poll status has changed. Please refresh the page.');
            return true;
        }

        if($this->poll->votes()->count() === 0) {
            session()->flash('error', 'You cannot close a poll without any votes.');
            return true;
        }

        return false;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.modals.poll.close-poll');
    }

    /**
     * @return void
     */
    private function updateStatus(): void
    {
        if ($this->poll->status === 'active') {
            $this->poll->update(['status' => 'closed']);
        } else {
            $this->poll->update(['status' => 'active']);
            if ($this->poll->event) {
                $this->eventService->deleteEvent($this->poll->event);
            }
        }
    }
}
