<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.create') }}</x-slot>

    <div class="tw-max-w-5xl text-center mx-auto">
        <h1 class="tw-mb-8 tw-font-medium tw-text-3xl">{{ __('pages/poll-editor.page.create') }}</h1>
        <div class="tw-card tw-bg-base-100 tw-mb-5 tw-p-3 tw-shadow-sm">
            <ul class="tw-steps">
                <li class="tw-step tw-step-primary">Poll information</li>
                <li class="tw-step tw-step-primary">Time Options</li>
                <li class="tw-step tw-step-primary">Questions</li>
                <li class="tw-step tw-step-primary">Poll settings</li>
            </ul>
        </div>

        <!-- Livewire komponenta pro celý formulář pro vytvoření nové ankety -->
        <livewire:pages.poll-editor />
    </div>

</x-layouts.app>
