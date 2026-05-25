{{-- Formulář pro vytvoření a úpravu ankety --}}
<div>
    <x-mary-toast />

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


        <div class="card mb-3 p-2 shadow-sm bg-base-100 col-span-2">
            <div class="flex justify--between items-center">
                <div>
                    @if($poll)
                        <a class="btn btn-soft text-left" href="{{ route('polls.show', $poll) }}">
                            {{ __('pages/poll-editor.button.return') }}
                        </a>
                    @endif
                </div>
                <div class="flex gap-2 grow flex-row-reverse items-center">

                    <button class="btn btn-primary"
                            type="submit">
                        {{ __('pages/poll-editor.button.submit') }}
                    </button>
                    <div class="ms-2" wire:loading wire:target="submit">
                        <div class="loading loading-spinner loading-sm" role="status">
                        </div>
                        {{ __('pages/poll-editor.loading') }}
                    </div>
                    @error('error')
                    <span class="text-error">
                    {{ $message }}
                </span>
                    @enderror
                </div>
            </div>

        </div>
    </form>


</div>

