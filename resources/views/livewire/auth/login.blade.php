<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Log in</h2>
            <form wire:submit="login">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <x-input id="email" model="form.email" type="email" mandatory="true">
                        Email
                    </x-input>
                </div>

                {{-- Heslo --}}
                <div class="mb-3">
                    <x-input id="password" model="form.password" type="password" mandatory="true">
                        Password
                    </x-input>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input wire:model="form.remember" type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>

                <div class="mb-1">
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Forgot your password?</a>
                </div>

                <div class="mb-2">
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary">
                        Don't have an account? Register
                    </a>
                </div>




                <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                    <button type="submit" class="btn btn-primary w-100">Log in</button>
                    <a href="{{ route('google.login') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-google"></i>  Log in with Google
                    </a>
                </div>



            </form>
        </div>
    </div>
</div>
