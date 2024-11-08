<div class="container py-5">

    <form wire:submit.prevent="login" class="card p-4 shadow-sm col-lg-6 mx-auto">
        <h2 class="mb-4 text-center">{{ __('Log In') }}</h2>

        <x-form.text-input type="email" name="form.email" id="email" label="{{ __('Email') }}" model="form.email" required />

        <x-form.text-input type="password" name="form.password" id="password" label="{{ __('Password') }}" model="form.password" required />

        <div class="form-check mb-3">
            <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input" name="remember">
            <label for="remember" class="form-check-label">{{ __('Remember me') }}</label>
        </div>


        <div class="d-flex justify-content-end align-items-center mt-4">
            
            @if (Route::has('password.request'))
                <a class="text-decoration-none small text-muted me-4" href="{{ route('password.request') }}"
                    wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <a href="{{ route('register') }}" class="text-decoration-none small text-muted me-4" wire:navigate>
                {{ __('Register') }}
            </a>

            <x-button type="submit">
                {{ __('Log in') }}
            </x-button>
        </div>

    </form>
</div>
