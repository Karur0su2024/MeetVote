<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        @if (session()->has('status'))
            <x-ui.alert type="info">
                {{ session('status') }}
            </x-ui.alert>
        @endif
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">{{ __('pages/auth.forgot_password.title') }}</h2>

            <p class="text-muted">
                {{ __('pages/auth.forgot_password.description') }}
            </p>

            <form class="mt-3 text-start" wire:submit.prevent="sendPasswordResetLink">

                <!-- Email -->
                <x-ui.form.input id="email" wire:model="email" type="email" label="Email" required>
                    {{ __('pages/auth.forgot_password.labels.email') }}
                </x-ui.form.input>

                <button class="btn btn-primary" type="submit">{{ __('pages/auth.forgot_password.buttons.send') }}</button>

                <x-ui.saving wire:loading>
                    {{ __('pages/auth.forgot_password.loading') }}
                </x-ui.saving>



            </form>
        </div>
    </div>
</div>
