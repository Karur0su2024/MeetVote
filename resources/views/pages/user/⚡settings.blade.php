<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    public $selectedTab = 'profile-settings-tab';
};
?>

<x-layouts.app>
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <div class="card bg-base-100 p-2">


        <x-mary-tabs wire:model="selectedTab" label-class="tabs-box p-2 border-gray-400" label-div-class="bg-gray-300/15 rounded-box" active-class="bg-primary rounded !text-white" class="w-full">
            <x-mary-tab name="profile-settings-tab" label="{{ __('pages/user-settings.profile_settings.title') }}" icon="o-user">
                <div>
                    <livewire:user.settings.profile-settings/>
                </div>
            </x-mary-tab>
            <x-mary-tab name="password-settings-tab" label="{{ __('pages/user-settings.profile_settings.title') }}" icon="o-lock-closed">
                <div>
                    <livewire:user.settings.password-settings/>
                </div>
            </x-mary-tab>
            <x-mary-tab name="google-settings-tab" label="{{ __('pages/user-settings.google.title') }}" disabled icon="o-calendar">
                <div>
                    <livewire:user.settings.google-settings/>
                </div>
            </x-mary-tab>
            <x-mary-tab name="delete-user-tab" label="{{ __('pages/user-settings.delete_account.title') }}" icon="o-trash">
                <div>
                    <livewire:user.settings.delete-account/>
                </div>
            </x-mary-tab>
        </x-mary-tabs>
    </div>


</x-layouts.app>
