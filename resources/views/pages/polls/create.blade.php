<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.create') }}</x-slot>

    <div class="flex flex-col mb-3">

        <div class="card bg-base-100 text-center p-4 shadow-sm">

            <x-ui.text.title-xl>
                {{ __('pages/poll-editor.page.create') }}
            </x-ui.text.title-xl>

{{--
            <x-mary-steps wire:model="example" stepper-classes="w-full p-5 bg-base-200">
                <x-mary-step step="1" text="Poll information" class="step-primary" />
                <x-mary-step step="2" text="Time options" />
                <x-mary-step step="3" text="Questions" />
                <x-mary-step step="4" text="Poll settings" />
            </x-mary-steps>
--}}

            <ul class="steps">
                <li class="step step-primary">Poll information</li>
                <li class="step">Time options</li>
                <li class="step">Questions</li>
                <li class="step">Poll settings</li>
            </ul>
        </div>

    </div>

    <livewire:pages.poll-editor/>

</x-layouts.app>
