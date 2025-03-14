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

    protected EventService $eventService;


    public function boot(EventService $eventService) {
        $this->eventService = $eventService;
    }

    public function mount($publicIndex) {
        $this->poll = Poll::where('public_id', $publicIndex)->first();

        if (!$this->poll) {
            session()->flash('error', 'Poll not found.');
            return;
        }

    }



    // Metoda pro zavření hlasování
    // Následně se načte stránka
    public function closePoll()
    {
        try {
            DB::beginTransaction();

            $currentPoll = Poll::where('public_id', $this->poll->public_id)->first();

            if ($currentPoll->status !== $this->poll->status) {
                session()->flash('error', 'The poll status has changed. Please refresh the page.');
                return;
            }

            if($this->poll->votes()->count() === 0) {
                session()->flash('error', 'You cannot close a poll without any votes.');
                return;
            }

            if($this->poll->status === 'active') {
                $this->poll->update(['status' => 'closed']);
            }
            else {
                $this->poll->update(['status' => 'active']);
                if($this->poll->event) {
                    $this->eventService->deleteEvent($this->poll->event);
                }
            }

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while closing poll.');
            DB::rollBack();
            return;
        }

        DB::commit();
        return redirect()->route('polls.show', ['poll' => $this->poll->public_id]); // Aktualizace stránky

    }

    public function render()
    {
        return view('livewire.modals.poll.close-poll');
    }
}
