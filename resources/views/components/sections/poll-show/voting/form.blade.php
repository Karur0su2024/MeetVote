<div class="flex gap-3">
    <div class="basis-1/2">
        <x-mary-input label="{{ __('pages/poll-show.voting.form.username.label') }}"
                      class="flex-1"
                      wire:model="form.user.name"
                      type="email"
                      required
                      :disabled="$poll->settings['anonymous_votes']"
                      placeholder="{{ __('pages/poll-show.voting.form.username.placeholder') }}"
                      hint="{{ empty($poll->settings['anonymous_votes']) ? '' : 'Poll is anonymous, so you don\'t need to fill in your name.' }}" />
    </div>
    <div class="basis-1/2">
        <x-mary-input label="{{ __('pages/poll-show.voting.form.email.label') }}"
                      wire:model="form.user.email"
                      type="email"
                      class="flex-auto"
                      required
                      placeholder="{{ __('pages/poll-show.voting.form.email.placeholder') }}"/>
    </div>


</div>
