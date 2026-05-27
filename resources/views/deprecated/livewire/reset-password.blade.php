<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        @if (session()->has('status'))
            <x-ui.alert type="info">
                {{ session('status') }}
            </x-ui.alert>
        @endif
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">{{ __('pages/auth.reset_password.title') }}</h2>

            <p class="text-muted">
                {{ __('pages/auth.reset_password.description') }}
            </p>

            <form wire:submit="resetPassword">


                {{-- Heslo --}}
                <x-ui.form.input id="password" wire:model="password" type="password" label="Password" required error="password">
                    {{ __('pages/auth.reset_password.labels.password') }}
                </x-ui.form.input>


                {{-- Potvrzení hesla --}}
                <x-ui.form.input id="password_confirmation" wire:model="password_confirmation" type="password" required error="password_confirmation">
                    {{ __('pages/auth.reset_password.labels.confirm_password') }}
                </x-ui.form.input>

                <x-ui.saving wire:loading>
                    {{ __('pages/auth.reset_password.loading') }}
                </x-ui.saving>


                <button class="btn btn-primary">
                    {{ __('pages/auth.reset_password.buttons.reset') }}
                </button>
            </form>
        </div>
    </div>
</div>
