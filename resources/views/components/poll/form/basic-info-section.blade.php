@props([
    /** @var \null */
    'poll'
])

<x-card>

    {{-- Hlavička --}}
    <x-slot:header>{{ __('form.section.title.basic_info') }}</x-slot:header>

    {{-- Tooltip --}}

    {{-- Název ankety --}}
    <x-ui.form.input
        id="title"
        x-model="form.title"
        type="text"
        placeholder="New poll"
        error="form.title">
        {{ __('form.label.title') }}
    </x-ui.form.input>

    {{-- Popis ankety --}}
    <x-ui.form.textbox
        id="description"
        x-model="form.description"
        placeholder="Your poll's description..."
        error="form.description">
        {{ __('form.label.description') }}
    </x-ui.form.textbox>

    {{-- Deadline ankety --}}
    <x-ui.form.input
        id="deadline"
        x-model="form.deadline"
        type="date"
        error="form.deadline">
        <x-slot:tooltip>
            {{ __('form.tooltip.deadline') }}
        </x-slot:tooltip>
        {{ __('form.label.deadline') }}
    </x-ui.form.input>

    {{-- Informace o autorovi --}}
    @if (!$poll->id)
        <x-poll.form.author-info-section />
    @endif

</x-card>
