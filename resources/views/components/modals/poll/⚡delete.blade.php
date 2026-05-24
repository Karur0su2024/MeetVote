<?php

use Livewire\Component;

new class extends Component {
    public $poll;
    public $showModal = false;

    public $listeners = [
        'openPollDeleteModal' => 'openModal',
    ];

    public function mount($poll)
    {
        $this->poll = $poll;
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

    public function openModal()
    {
        $this->showModal = true;
    }

};
?>

<x-mary-modal wire:model="showModal"
              title="{{ __('ui/modals.delete_poll.title') }}"
              class="backdrop-blur z-10">
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
</x-mary-modal>
