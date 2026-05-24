<div class="flex justify-between">
    @if(empty($poll->settings['anonymous_votes']))

    @endif
    <div>
        <x-ui.form.tw-input
            id="name"
            wire:model="form.user.name"
            data-class="form-control-lg"
            :disabled="$poll->settings['anonymous_votes']"
            required
            placeholder="{{ __('pages/poll-show.voting.form.username.placeholder') }}">
            <x-slot:label>
                @if($poll->settings['anonymous_votes'])
                    <x-slot:tooltip>ł
                        Poll is anonymous, so you don't need to fill in your name.
                    </x-slot:tooltip>
                @endif

                {{ __('pages/poll-show.voting.form.username.label') }}
            </x-slot:label>
        </x-ui.form.tw-input>

    </div>
    <div>
        <x-ui.form.tw-input
            id="email"
            wire:model="form.user.email"
            type="email"
            required
            placeholder="{{ __('pages/poll-show.voting.form.email.placeholder') }}">
            <x-slot:label>
                {{ __('pages/poll-show.voting.form.email.label') }}

            </x-slot:label>
        </x-ui.form.tw-input>
    </div>
</div>
