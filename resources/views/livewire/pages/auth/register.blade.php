<div class="container py-5">
    <form wire:submit="register" class="card p-4 shadow-sm col-lg-6 mx-auto">

        
        <h2 class="mb-4 text-center">{{ __('Registration') }}</h2>

        <x-form.text-input type="text" name="form.username" id="username" label="{{ __('Username') }}" model="form.username" required />

        <x-form.text-input type="email" name="form.email" id="email" label="{{ __('Email') }}" model="form.email" required />

        <x-form.text-input type="password" name="form.password" id="password" label="{{ __('Password') }}" model="form.password" required />

        <x-form.text-input type="password" name="form.password_confirmation" id="password_confirmation" label="{{ __('Password Confirmation') }}" model="form.password_confirmation" required />
        
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none small text-muted me-4" wire:navigate>
                {{ __('Already registered?') }}
            </a>
        
            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
        
    </form>
</div>
