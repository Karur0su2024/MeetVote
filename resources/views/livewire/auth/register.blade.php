<div class="container mt-5">
    <form class="card p-4 text-start" wire:submit="register">
        @csrf

        <!-- Name -->
        <x-input id="name" model="form.name" type="text" label="Name" mandatory="true" />

        <!-- Email -->
        <x-input id="email" model="form.email" type="email" label="Email" mandatory="true" />

        <!-- Password -->
        <x-input id="password" model="form.password" type="password" label="Password" mandatory="true" />

        <!-- Confirm Password -->
        <x-input id="password_confirmation" model="form.password_confirmation" type="password" label="Confirm password"
            mandatory="true" />


        <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Already registered?') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
    </form>
</div>
