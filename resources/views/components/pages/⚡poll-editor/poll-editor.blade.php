{{-- Formulář pro vytvoření a úpravu ankety --}}
<div>
    <form class="flex flex-col gap-3" wire:submit.prevent="submit">

        <div class="grid grid-flow-row grid-cols-2 gap-4">
            {{-- Základní informace o anketě --}}
            <div class="col-span-1 grid grid-cols-1 gap-4">
                <x-pages.poll-editor.basic-info-section :poll-index="$pollIndex" :timezones="$timezones"/>
                <x-pages.poll-editor.questions.section/>
            </div>
            <div class="col-span-1 grid grid-cols-1 gap-4">
                <x-pages.poll-editor.time-options.section/>
                <x-pages.poll-editor.settings-section/>
            </div>
        </div>

        <x-ui.card class="px-2 py-2">
            <div class="flex flex-row-reverse justify-between items-center">
                <x-mary-button label="{{ __('pages/poll-editor.button.submit') }}"
                               class="btn-primary"
                               type="submit"
                               spinner />
                @if($poll)
                    <a class="btn btn-soft text-left" href="{{ route('polls.show', $poll) }}">
                        {{ __('pages/poll-editor.button.return') }}
                    </a>
                @endif
            </div>
        </x-ui.card>

        @error('error')
        <span class="text-error">
                    {{ $message }}
                    </span>
        @enderror
    </form>
</div>

