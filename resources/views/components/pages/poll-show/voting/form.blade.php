<div class="row">
    <h3 class="mb-4 pb-2 fw-bold">
        Your information
    </h3>
    <div class="col-md-6 mb-3">
        <x-ui.form.input
                id="name"
                x-model="form.user.name"
                required
                data-class="form-control-lg">
            Your name
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
                required
                data-class="form-control-lg">
            Your e-mail
        </x-ui.form.input>
        <div x-show="messages.errors['form.user.email']" class="text-danger">
            <span x-text="messages.errors['form.user.email']"></span>
        </div>
    </div>
</div>
