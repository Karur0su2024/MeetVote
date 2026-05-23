<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.create') }}</x-slot>

    <div class="flex flex-col mb-3">

        <div class="card bg-base-100 text-center p-4 shadow-sm">
            <h2 class="mb-8 font-medium text-3xl">{{ __('pages/poll-editor.page.create') }}</h2>
            <ul class="steps">
                <li class="step step-primary">Poll information</li>
                <li class="step step-primary">Time options</li>
                <li class="step">Questions</li>
                <li class="step">Poll settings</li>
            </ul>
        </div>

    </div>

    <livewire:pages.poll-editor/>

</x-layouts.app>
