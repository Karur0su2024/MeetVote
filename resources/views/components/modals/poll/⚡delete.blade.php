<?php

use Livewire\Component;
use App\Models\Poll;

new class extends Component {
    public $poll = null;
    public $showModal = false;

    public $listeners = [
        'openPollDeleteModal' => 'openModal',
    ];

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

    public function openModal($pollId)
    {
        $this->poll = Poll::find($pollId);
        $this->showModal = true;
    }

};
?>

<x-mary-modal wire:model="showModal"
              title="{{ __('ui/modals.delete_poll.title') }}"
              class="backdrop-blur z-10">

    @if($poll)
        <x-mary-alert
            title="{{ __('ui/modals.delete_poll.text.question') . ' ' . __('ui/modals.delete_poll.text.warning') }}"
            class="alert-error"
            icon="o-exclamation-triangle"/>

        @if (session()->has('error'))
            <span class="text-danger">
                {{ session('error') }}
            </span>
        @endif
        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.showModal = false"
            />
            <x-mary-button
                label="{{ __('ui/modals.invitations.table.actions.delete') }}"
                class="btn-error"
                wire:click="deletePoll()"
            />
        </x-slot:actions>
    @endif
</x-mary-modal>
