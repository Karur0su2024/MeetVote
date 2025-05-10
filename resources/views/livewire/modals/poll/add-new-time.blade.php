{{-- Modální okno pro přidání nové časové možnosti --}}
<div>
    <x-ui.modal.header :poll="$poll">
        {{ __('ui/modals.add_new_time_option.title', ['poll_title' => $poll->title]) }}
    </x-ui.modal.header>
    <div class="modal-body" x-data="{ type: @entangle('option.type') }">
        <form wire:submit.prevent="submit">

            {{-- Přepínání časového a textového typu --}}
            <ul class="nav nav-pills mb-3">
                <li class="nav-item">

                    <x-ui.button class="nav-link"
                                 color=""
                                 x-bind:class="{ 'active': type === 'time' }"
                                 @click="type= 'time'">
                        {{ __('ui/modals.add_new_time_option.buttons.time_option') }}
                    </x-ui.button>
                </li>
                <li class="nav-item">
                    <x-ui.button class="nav-link"
                                 color=""
                                 x-bind:class="{ 'active': type === 'text' }"
                                 @click="type= 'text'">
                        {{ __('ui/modals.add_new_time_option.buttons.text_option') }}
                    </x-ui.button>
                </li>
            </ul>

            {{-- Zobrazení data --}}
            <x-ui.form.input id="date"
                             wire:model="option.date"
                             type="date"
                             required
                             placeholder="{{ __('ui/modals.add_new_time_option.date.placeholder') }}">
                {{ __('ui/modals.add_new_time_option.date.label') }}
            </x-ui.form.input>

            {{-- Zobrazeno pouze v případě nastaveného typu na time --}}
            <template x-if="type === 'time'">
                <div class="mb-3">

                    {{-- Pole pro zadání začátku časového intervalu  --}}
                    <x-ui.form.input id="start"
                                     wire:model="option.content.start"
                                     type="time"
                                     required
                                     placeholder="{{ __('ui/modals.add_new_time_option.start_time.placeholder') }}">
                        {{ __('ui/modals.add_new_time_option.start_time.label') }}
                    </x-ui.form.input>

                    {{-- Pole pro zadání konce časového intervalu --}}
                    <x-ui.form.input id="end"
                                     wire:model="option.content.end"
                                     type="time"
                                     required
                                     placeholder="__('ui/modals.add_new_time_option.end_time.placeholder')"
                                     error="option.content.end">
                        {{ __('ui/modals.add_new_time_option.end_time.label') }}
                    </x-ui.form.input>

                </div>
            </template>
            <template x-if="type === 'text'">
                <div class="mb-3" x-show="type === 'text'">
                    <x-ui.form.input id="text"
                                     wire:model="option.content.text"
                                     type="text"
                                     placeholder="{{ __('ui/modals.add_new_time_option.text.placeholder') }}">
                        {{ __('ui/modals.add_new_time_option.text.label') }}
                    </x-ui.form.input>
                </div>
            </template>

            <x-ui.button type="submit">
                {{ __('ui/modals.add_new_time_option.buttons.add_option') }}
            </x-ui.button>

            <x-ui.saving wire:loading>
                {{ __('ui/modals.add_new_time_option.loading') }}
            </x-ui.saving>

            {{-- Chybové hlášky --}}
            <x-ui.form.error-text error="error" />
            <x-ui.form.error-text error="option" />

        </form>
    </div>
</div>
