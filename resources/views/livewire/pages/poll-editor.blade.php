{{-- Formulář pro vytvoření a úpravu ankety --}}
<div>


    <form wire:submit.prevent="submit" class="max-w-5xl mx-auto space-y-12">

        {{-- Základní informace o anketě --}}
        <x-pages.poll-editor.basic-info-section-new :poll-index="$pollIndex" :timezones="$timezones"/>

        {{-- Výběr časových termínů --}}
        <x-pages.poll-editor.time-options-new.section />
{{--        <x-pages.poll-editor.time-options.scheduler />--}}

        <div class="flex flex-row space-x-3">
            <div class="flex-1">
                <x-pages.poll-editor.questions-new.section/>
            </div>
            <div class="flex-1">
                <x-pages.poll-editor.settings-section-new />
            </div>
        </div>



        <x-ui.panel>
            @if($poll)
                <x-slot:left>
                    <a class="btn btn-secondary text-start" href="{{ route('polls.show', $poll) }}">
                        {{ __('pages/poll-editor.button.return') }}
                    </a>
                </x-slot:left>
            @endif
            <x-slot:right>

                <x-ui.button type="submit">
                    {{ __('pages/poll-editor.button.submit') }}
                </x-ui.button>
                @error('error')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror

                @if ($errors->any())
                    <span class="text-danger">
                        {{ __('pages/poll-editor.messages.error.general') }}
                    </span>

                 @endif
                </form>

                <x-ui.spinner wire:loading wire:target="submit">
                    {{ __('pages/poll-editor.loading') }}
                </x-ui.spinner>
            </x-slot:right>
        </x-ui.panel>
    </form>
</div>
