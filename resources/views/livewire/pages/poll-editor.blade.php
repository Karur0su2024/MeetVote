{{-- Formulář pro vytvoření a úpravu ankety --}}
<div>


    <form class="tw-flex tw-flex-col tw-gap-3" wire:submit.prevent="submit">

        {{-- Základní informace o anketě --}}
        <x-pages.poll-editor.basic-info-section :poll-index="$pollIndex" :timezones="$timezones"/>

        {{-- Výběr časových termínů --}}
        <x-pages.poll-editor.time-options.section/>

        <div class="row">
            {{-- Výběr doplňujících otázek --}}
            <div class="col-6">
                <x-pages.poll-editor.questions.section/>
            </div>
            <div class="col-6">
                <x-pages.poll-editor.settings-section/>
            </div>
        </div>



        <x-ui.panel>
            @if($poll)
                <x-slot:left>
                    <a class="tw-btn tw-btn-soft text-start" href="{{ route('polls.show', $poll) }}">
                        {{ __('pages/poll-editor.button.return') }}
                    </a>
                </x-slot:left>
            @endif
            <x-slot:right>

                <button class="tw-btn tw-btn-primary"
                        type="submit">
                    {{ __('pages/poll-editor.button.submit') }}
                </button>
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
