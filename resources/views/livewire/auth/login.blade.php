<div class="container d-flex justify-content-center align-items-center text-start pt-5">
    <div class="col-md-6">
        @if (session()->has('status'))
            <x-ui.alert type="info">
                {{ session('status') }}
            </x-ui.alert>
        @endif
        @if(session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <div class="card shadow p-4">
            <h2 class="text-center mb-4">{{ __('pages/auth.login.title') }}</h2>
            <form wire:submit="login">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <x-ui.form.input id="email"
                                     wire:model="form.email"
                                     type="email"
                                     required
                                     error="form.email">
                        {{ __('pages/auth.login.labels.email') }}
                    </x-ui.form.input>
                </div>

                {{-- Heslo --}}
                <div class="mb-3">
                    <x-ui.form.input id="password"
                                     wire:model="form.password"
                                     type="password"
                                     required
                                     error="form.password">
                        {{ __('pages/auth.login.labels.password') }}
                    </x-ui.form.input>
                </div>

                {{-- Zapamatovat si mě --}}
                <x-ui.form.checkbox wire:model="form.remember"
                                    type="checkbox"
                                    id="remember"
                                    name="remember">
                    {{ __('pages/auth.login.labels.remember_me') }}
                </x-ui.form.checkbox>

                <div class="mb-1">
                    <a href="{{ route('password.request') }}"
                       class="text-decoration-none text-primary">{{ __('pages/auth.login.buttons.forgot_password') }}</a>
                </div>

                <div class="mb-2">
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary">
                        {{ __('pages/auth.login.buttons.not_registered') }}
                    </a>
                </div>


                <div class="d-flex justify-content-center align-items-center mb-3 gap-2">
                    <button type="submit"
                            class="btn btn-primary w-100">{{ __('pages/auth.login.buttons.login') }}</button>
                    <a href="{{ route('google.oath.login') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                    </a>
                </div>
                <x-ui.saving wire:loading>
                    {{ __('pages/auth.login.loading') }}
                </x-ui.saving>
            </form>
        </div>
    </div>
</div>
