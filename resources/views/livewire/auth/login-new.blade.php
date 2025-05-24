<div class="card bg-base-100 shadow-md p-5 max-w-md mx-auto">
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
            <h2 class="card-title text-3xl font-semibold mb-3" >{{ __('pages/auth.login.title') }}</h2>
            <form wire:submit="login">
                <x-ui.form.input-new id="email"
                                 wire:model="form.email"
                                 type="email"
                                 required
                                 error="form.email">
                    {{ __('pages/auth.login.labels.email') }}
                </x-ui.form.input-new>
                <x-ui.form.input-new id="password"
                                 wire:model="form.password"
                                 type="password"
                                 required
                                 error="form.password">
                    {{ __('pages/auth.login.labels.password') }}
                </x-ui.form.input-new>

                <div class="mt-5">
                    <button class="btn btn-outline btn-primary">
                        {{ __('pages/auth.login.buttons.login') }}
                    </button>
                    <a href="{{ route('google.oath.login') }}" class="btn w-100">
                        <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                    </a>
                </div>
            </form>





{{--                --}}{{-- Zapamatovat si mě --}}
{{--                <x-ui.form.checkbox wire:model="form.remember"--}}
{{--                                    type="checkbox"--}}
{{--                                    id="remember"--}}
{{--                                    name="remember">--}}
{{--                    {{ __('pages/auth.login.labels.remember_me') }}--}}
{{--                </x-ui.form.checkbox>--}}

{{--                <div class="mb-1">--}}
{{--                    <a href="{{ route('password.request') }}"--}}
{{--                       class="text-decoration-none text-primary">{{ __('pages/auth.login.buttons.forgot_password') }}</a>--}}
{{--                </div>--}}

{{--                <div class="mb-2">--}}
{{--                    <a href="{{ route('register') }}" class="text-decoration-none text-primary">--}}
{{--                        {{ __('pages/auth.login.buttons.not_registered') }}--}}
{{--                    </a>--}}
{{--                </div>--}}

</div>
