<div class="row">
    @if(empty($poll->settings['anonymous_votes']))

    @endif
        <div class="col-md-6 mb-3">
            <x-ui.form.input
                id="name"
                wire:model="form.user.name"
                data-class="form-control-lg"
                :disabled="$poll->settings['anonymous_votes']"
                required
                placeholder="{{ __('pages/poll-show.voting.form.username.placeholder') }}">
                @if($poll->settings['anonymous_votes'])
                    <x-slot:tooltip>
                        Poll is anonymous, so you don't need to fill in your name.
                    </x-slot:tooltip>
                @endif

                {{ __('pages/poll-show.voting.form.username.label') }}
            </x-ui.form.input>

        </div>
    <div class="col-md-6 mb-3">
        <x-ui.form.input
            id="email"
            wire:model="form.user.email"
            type="email"
            data-class="form-control-lg"
            required
            placeholder="{{ __('pages/poll-show.voting.form.email.placeholder') }}">
            <x-slot:tooltip>
                You address will be used to send you an email with the results of the poll.
                Your email will not be shared with anyone.
            </x-slot:tooltip>
            {{ __('pages/poll-show.voting.form.email.label') }}
        </x-ui.form.input>
    </div>
</div>
