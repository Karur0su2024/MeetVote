<div class="container mt-5">
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

        <form class="card p-4 text-start" wire:submit="login">
        @csrf
        
        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-control" required autofocus autocomplete="username" wire:model="form.email">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" wire:model="form.password">
            @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input wire:model="form.remember" type="checkbox" id="remember" name="remember" class="form-check-input">
            <label for="remember" class="form-check-label">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">{{ __('Forgot your password?') }}</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-decoration-none">{{ __('registration here') }}</a>
            @endif
            <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
            <!--Sem později přidat tlačítko pro přihlášení přes Google-->
        </div>
    </form>
</div>

