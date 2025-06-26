<div class="card bg-base-100 shadow-md p-5 max-w-md mx-auto">
    @if (session()->has('status'))
        <x-ui.alert type="info">
            {{ session('status') }}
        </x-ui.alert>
    @endif
    <h2 class="card-title text-3xl font-semibold mb-3" >{{ __('pages/auth.register.title') }}</h2>
    <form wire:submit="register">
        <x-ui.form.input-new id="name" wire:model="form.name" type="text" required error="form.name">
            {{ __('pages/auth.register.labels.name') }}
        </x-ui.form.input-new>

        <!-- Email -->
        <x-ui.form.input-new id="email" wire:model="form.email" type="email" required error="form.email">
            {{ __('pages/auth.register.labels.email') }}
        </x-ui.form.input-new>
        <!-- Password -->
        <x-ui.form.input-new id="password" wire:model="form.password" type="password" required error="form.password">
            {{ __('pages/auth.register.labels.password') }}
        </x-ui.form.input-new>

        <!-- Confirm Password -->
        <x-ui.form.input-new id="password_confirmation" wire:model="form.password_confirmation" type="password" required
                         error="form.password_confirmation">
            {{ __('pages/auth.register.labels.confirm_password') }}
        </x-ui.form.input-new>

        <div class="mt-5">
            <button class="btn btn-outline btn-primary">
                {{ __('pages/auth.register.buttons.register') }}
            </button>
            <a href="{{ route('google.oath.login') }}" class="btn w-100">
                <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
            </a>
        </div>
    </form>



</div>


{{--<div class="container d-flex justify-content-center align-items-center text-start pt-5">--}}
{{--    <div class="col-md-6">--}}

{{--        <div class="card shadow p-4">--}}
{{--            <h2 class="text-center mb-4">{{ __('pages/auth.register.title') }}</h2>--}}
{{--            <form wire:submit="register">--}}



{{--                <div class="d-flex justify-content-between align-items-center mb-3">--}}
{{--                    <a href="{{ route('login') }}" class="text-decoration-none text-primary">{{ __('pages/auth.register.buttons.already_registered') }}</a>--}}
{{--                </div>--}}

{{--                <div class="d-flex justify-content-center align-items-center mb-3 gap-2">--}}
{{--                    <button type="submit" class="btn btn-primary w-100">{{ __('pages/auth.register.buttons.register') }}</button>--}}
{{--                    <a href="{{ route('google.oath.login') }}" class="btn btn-outline-primary w-100">--}}
{{--                        <i class="bi bi-google"></i> {{ __('pages/auth.register.buttons.with_google') }}--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <x-ui.saving wire:loading>--}}
{{--                    {{ __('pages/auth.register.loading') }}--}}
{{--                </x-ui.saving>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


