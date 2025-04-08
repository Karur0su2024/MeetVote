<div class="row">
    <div class="col-md-6 mb-3">
        <x-ui.form.input
                id="name"
                x-model="form.user.name"
                data-class="form-control-lg"
                required
                placeholder="{{ __('pages/poll-show.voting.form.username.placeholder') }}">
            {{ __('pages/poll-show.voting.form.username.label') }}
        </x-ui.form.input>
        <div x-show="messages.errors['form.user.name']" class="text-danger">
            <span x-text="messages.errors['form.user.name']"></span>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <x-ui.form.input
                id="email"
                x-model="form.user.email"
                type="email"
                data-class="form-control-lg"
                required
                placeholder="{{ __('pages/poll-show.voting.form.email.placeholder') }}">
            {{ __('pages/poll-show.voting.form.email.label') }}
        </x-ui.form.input>
        <div x-show="messages.errors['form.user.email']" class="text-danger">
            <span x-text="messages.errors['form.user.email']"></span>
        </div>
    </div>
</div>
