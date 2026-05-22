{{-- Formulář pro vytvoření a úpravu ankety --}}
<div>


    <form class="tw:flex tw:flex-col tw:gap-3" wire:submit.prevent="submit">

        <div class="tw:grid tw:grid-flow-row tw:grid-cols-2 tw:gap-4">
            {{-- Základní informace o anketě --}}
            <div class="tw:col-span-2">
                <x-pages.poll-editor.basic-info-section :poll-index="$pollIndex" :timezones="$timezones"/>
            </div>


            {{-- Výběr časových termínů --}}
            <div class="tw:col-span-2">
                <x-pages.poll-editor.time-options.section/>
            </div>

            <div class="tw:col-span-1">
                <x-pages.poll-editor.questions.section/>
            </div>
            <div class="tw:col-span-1">
                <x-pages.poll-editor.settings-section/>
            </div>
        </div>


        <div class="tw:card mb-3 p-2 tw:shadow-sm tw:bg-base-100 tw:col-span-2">
            <div class="tw:flex tw:justify--between tw:items-center">
                <div>
                    @if($poll)
                        <a class="tw:btn tw:btn-soft tw:text-left" href="{{ route('polls.show', $poll) }}">
                            {{ __('pages/poll-editor.button.return') }}
                        </a>
                    @endif
                </div>
                <div class="tw:flex tw:gap-2 tw:grow tw:flex-row-reverse tw:items-center">

                    <button class="tw:btn tw:btn-primary"
                            type="submit">
                        {{ __('pages/poll-editor.button.submit') }}
                    </button>
                    @error('error')
                    <span class="tw:text-error">
                    {{ $message }}
                </span>
                    @enderror

                    @if ($errors->any())
                        <span class="tw:text-error">
                        {{ __('pages/poll-editor.messages.error.general') }}
                    </span>

        @endif
    </form>

    <div class="ms-2" wire:loading wire:target="submit">
        <div class="tw:loading tw:loading-spinner tw:loading-sm" role="status">
        </div>
        {{ __('pages/poll-editor.loading') }}
    </div>


</div>

