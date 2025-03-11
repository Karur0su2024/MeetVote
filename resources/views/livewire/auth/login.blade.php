<div class="container mt-5">
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form class="card p-4 text-start" wire:submit="login">
        @csrf


        {{-- Email --}}
        <x-input id="email" model="form.email" type="email" mandatory="true">
            Email
        </x-input>


        {{-- Heslo --}}
        <x-input id="password" model="form.password" type="password"  mandatory="true">
            Password
        </x-input>




        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input wire:model="form.remember" type="checkbox" id="remember" name="remember" class="form-check-input">
            <label for="remember" class="form-check-label">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-decoration-none">{{ __('Forgot your password?') }}</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-decoration-none">{{ __('registration here') }}</a>
            @endif

            <div class="mb-3">
                {{-- Tlačítko pro přihlášení --}}
                <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>

                {{-- Sem později přidat tlačítko pro přihlášení přes Google --}}
            </div>

        </div>
    </form>
</div>
