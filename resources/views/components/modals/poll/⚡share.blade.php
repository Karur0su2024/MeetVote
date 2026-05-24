<?php

use Livewire\Component;
use App\Models\Poll;

new class extends Component {
    public bool $showModal = false;
    public $poll;
    public $link;
    public $adminLink;

    public $listeners = [
        'openShareModal' => 'openModal',
    ];

    public function mount($poll)
    {
        $this->poll = $poll;

    }

    public function openModal()
    {
        $this->showModal = true;
        if (Gate::allows('isAdmin', $this->poll)) {
            $this->link = route('polls.show', ['poll' => $this->poll->public_id]);
            $this->adminLink = route('polls.show.admin', ['poll' => $this->poll->public_id, 'admin_key' => $this->poll->admin_key]);
        } else {
            $this->link = '[REDACTED]';
            $this->adminLink = '[REDACTED]';
        }
    }

};
?>

<div x-data="() => {
        return {
        // Alpine.js pro zkopírování URL adresy
                link: false,
                admin_link: false,
                copyToClipboard(id) {
                    if(id == 'link') {
                        this.admin_link = false;
                        this.link = true;
                    } else {
                        this.link = false;
                        this.admin_link = true;
                    }
                    input = document.getElementById(id);
                    navigator.clipboard.writeText(input.value);
                }

            };
        }">


    <x-mary-modal wire:model="showModal"
                  title="{{ __('ui/modals.share.title') }}"
                  class="backdrop-blur z-10">
        <div class="mb-2">
            <label for="link" class="text-lg">{{ __('ui/modals.share.labels.link') }}</label>
            <label class="text-xs">
                {{ __('ui/modals.share.text.link') }}
            </label>


            <x-mary-input value="{{ $link }}" readonly>
                <x-slot:append>
                    {{-- Add `join-item` to all appended elements --}}
                    <x-mary-button label="{{ __('ui/modals.share.button.copy') }}"
                                   @click="copyToClipboard('link')"
                                   class="join-item btn-primary"/>
                </x-slot:append>
            </x-mary-input>

            <div class="m-1">
                <small class="text-gray-400 text-xs" x-show="link">
                    {{ __('ui/modals.share.text.text_copied') }}
                </small>
            </div>
        </div>
        <div>

            <label for="admin_key" class="text-lg">{{ __('ui/modals.share.labels.admin_link') }}</label>

            <label class="text-xs">
                {{ __('ui/modals.share.text.admin_link') }}
            </label>

            <x-mary-input value="{{ $adminLink }}" readonly>
                <x-slot:append>
                    {{-- Add `join-item` to all appended elements --}}
                    <x-mary-button label="{{ __('ui/modals.share.button.copy') }}"
                                   @click="copyToClipboard('admin_key')"
                                   class="join-item btn-primary"/>
                </x-slot:append>
            </x-mary-input>
            <small class="text-gray-400 text-xs m-1" x-show="admin_link">
                {{ __('ui/modals.share.text.text_copied') }}
            </small>
        </div>

        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.showModal = false"/>
        </x-slot:actions>
    </x-mary-modal>
</div>
