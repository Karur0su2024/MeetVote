<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component {
    public $selectedTab = 'profile-settings-tab';
};
?>

<x-layouts.app>
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <div>
        <x-mary-tabs wire:model="selectedTab" label-class="tabs-box p-2" label-div-class="bg-base-100 rounded-box shadow-sm p-1 gap-2" active-class="bg-primary rounded !text-white">
            <x-mary-tab name="profile-settings-tab"
                        label="{{ __('pages/user-settings.profile_settings.title') }}"
                        icon="o-user"
                        class="bg-base-100 shadow-sm mt-1 card">
                <div class="px-4">
                    <livewire:sections.settings.profile-settings/>
                </div>
            </x-mary-tab>
            <x-mary-tab name="password-settings-tab"
                        label="{{ __('pages/user-settings.password.title') }}"
                        icon="o-lock-closed"
                        class="bg-base-100 shadow-sm mt-1 card">
                <div class="px-4">
                    <livewire:sections.settings.password-settings />
                </div>
            </x-mary-tab>
            <x-mary-tab name="google-settings-tab"
                        label="{{ __('pages/user-settings.google.title') }}"
                        icon="o-calendar"
                        class="bg-base-100 shadow-sm mt-1 card">
                <div class="px-4">
                    <livewire:sections.settings.google-settings />
                </div>
            </x-mary-tab>
            <x-mary-tab name="delete-user-tab"
                        label="{{ __('pages/user-settings.delete_account.title') }}"
                        icon="o-trash"
                        class="bg-base-100 shadow-sm mt-1 card">
                <div class="px-4">
                    <livewire:sections.settings.delete-account />
                </div>
            </x-mary-tab>
        </x-mary-tabs>
    </div>


</x-layouts.app>
