<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Register</h2>
            <form wire:submit="register">

                <!-- Name -->
                <x-input id="name" wire:model="form.name" type="text" required error="form.name">
                    Name
                </x-input>

                <!-- Email -->
                <x-input id="email" wire:model="form.email" type="email" required error="form.email">
                    Email
                </x-input>
                <!-- Password -->
                <x-input id="password" wire:model="form.password" type="password" required error="form.password">
                    Password
                </x-input>

                <!-- Confirm Password -->
                <x-input id="password_confirmation" wire:model="form.password_confirmation" type="password" required  error="form.password_confirmation">
                    Confirm password
                </x-input>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-primary">Already have an account? Log in</a>
                </div>

                <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <a href="{{ route('google.login') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-google"></i> Log in with Google
                    </a>
                </div>



            </form>
        </div>
    </div>
</div>
