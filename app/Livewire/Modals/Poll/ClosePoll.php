<?php

namespace App\Livewire\Modals\Poll;

use App\Events\PollReopened;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

// Modální okno pro uzavření a znovuotevření ankety
class ClosePoll extends Component
{
    public $poll;

    public $status;

    public $hasEvent;

    public $newDeadline;

    public function rules(): array
    {
        return [
            'newDeadline' => 'nullable|date|after:today', // Uzávěrka ankety
        ];
    }

    /**
     * @param  $pollId
     */
    public function mount($pollIndex): void
    {
        $this->poll = Poll::find($pollIndex);
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

    public function render()
    {
        return view('livewire.modals.poll.close-poll');
    }
}
