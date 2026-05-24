<?php

use Livewire\Component;
use App\Events\PollReopened;

new class extends Component {
    public $showModal = false;
    public $poll;
    public $newDeadline;
    public $hasEvent;

    public $listeners = [
        'openClosePollModal' => 'openModal'
    ];


    public function rules(): array
    {
        return [
            'newDeadline' => 'nullable|date|after:today', // Uzávěrka ankety
        ];
    }

    public function mount($poll)
    {
        $this->poll = $poll;

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
                return;
            }
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

};
?>

<x-mary-modal wire:model="showModal"
              title="{{ $poll->isActive() ? __('ui/modals.close_poll.title.close') : __('ui/modals.close_poll.title.reopen') }}"
              class="backdrop-blur z-10">
    @if (session()->has('error'))
        <span class="text-error">
                {{ session('error') }}
            </span>
    @else
        @if ($poll->isActive())
            @if (count($poll->votes) === 0)
                <x-mary-alert title="{{ __('ui/modals.close_poll.alerts.no_votes') }}"
                              class="alert-error"
                              icon="o-exclamation-triangle"/>
            @else
                <x-mary-alert class="alert-warning"
                              title="{{ __('ui/modals.close_poll.text.poll_count', ['count_poll_votes' => count($poll->votes)]) . ' ' . __('ui/modals.close_poll.text.is_user_sure') }}"
                              icon="o-exclamation-triangle"/>

            @endif
        @else
            <x-mary-alert class="alert-warning"
                          title="{{ __('ui/modals.close_poll.text.reopen') }}"
                          icon="o-exclamation-triangle"/>

            @if($hasEvent)
                <x-mary-alert class="alert-warning"
                              title="{{ __('ui/modals.close_poll.alerts.event_will_be_deleted') }}"
                              icon="o-exclamation-triangle"/>
            @endif
            <x-mary-datetime label="{{ __('ui/modals.close_poll.labels.new_deadline') }}"
                             wire:model="newDeadline"
            />

        @endif
    @endif
    <x-slot:actions>
        <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                       class="btn-neutral"
                       @click="$wire.showModal = false"
        />
        <x-mary-button
            label="{{ $poll->isActive() ? __('ui/modals.close_poll.buttons.close') : __('ui/modals.close_poll.buttons.reopen') }}"
            class="btn-error {{ count($poll->votes) === 0 ? 'btn-disabled' : '' }}"
            wire:click="closePoll()"
        />
    </x-slot:actions>
</x-mary-modal>
