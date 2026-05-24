<?php

use Livewire\Component;

new class extends Component
{
    public $myDate = null;
};
?>

<div x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">


    <x-ui.tw-card>
        <x-slot:title>
            {{ __('pages/poll-editor.time_options.title') }}
            <small>
                <x-ui.tooltip>
                    {{ __('pages/poll-editor.time_options.tooltip') }}
                </x-ui.tooltip>
            </small>
        </x-slot:title>
        <div class="flex gap-4">
            {{-- Blok s kalendářem --}}
            <div class="card bg-base-200 basis-1/2 p-2">
                <x-mary-datetime label="My date" wire:model="myDate">
                    <x-slot:append>
                        <x-mary-button label="Add date" @click="$wire.dispatch('newDate', {date: $wire.myDate})" class="btn-primary join-item "/>
                    </x-slot:append>
                </x-mary-datetime>

            </div>
            {{-- Blok s časovými možnostmi --}}
            <div class="card bg-base-200 basis-1/2">
                <div class="card-body">
                    <div class="card-content">
                        <template x-for="(date, dateIndex) in dates" :key="dateIndex">
                            <x-pages.poll-editor.time-options.date-card/>
                        </template>
                    </div>
                </div>


            </div>
        </div>
    </x-ui.tw-card>

</div>
