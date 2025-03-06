<div class="container mt-5">

    <div class="card p-4">
        <!-- Session Status -->
        <div class="text-dark">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-3 text-start" wire:submit="sendPasswordResetLink">
            @csrf

            <!-- Email -->
            <x-input id="email" model="email" type="email" label="Email" mandatory="true" />

            <button class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
        </form>
    </div>


</div>
