<div class="tw-flex tw-justify-center tw-items-center tw-pt-10">
    <div class="tw-w-full tw-max-w-md">
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

        <div class="tw-shadow-lg tw-bg-base-100">
            <div class="tw-card-body">
                <h2 class="tw-card-title card-title tw-justify-center tw-mb-4">{{ __('pages/auth.login.title') }}</h2>
                <form wire:submit="login">
                    @csrf
                    <x-ui.form.tw-input id="email"
                                        wire:model="form.email"
                                        type="email"
                                        required
                                        error="form.email">
                        <x-slot:label>
                            {{ __('pages/auth.login.labels.email') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>

                    <x-ui.form.tw-input id="password"
                                        wire:model="form.password"
                                        type="password"
                                        required
                                        error="form.password">
                        <x-slot:label>
                            {{ __('pages/auth.login.labels.password') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>

                    <div class="tw-text-left tw-flex tw-flex-col tw-gap-1 tw-mb-3">
                        <x-ui.form.tw-toggle wire:model="form.remember"
                                             type="checkbox"
                                             id="remember"
                                             name="remember">
                            {{ __('pages/auth.login.labels.remember_me') }}
                        </x-ui.form.tw-toggle>
                        <div class="tw-mb-1">
                            <a href="{{ route('password.request') }}"
                               class="tw-link tw-link-primary">{{ __('pages/auth.login.buttons.forgot_password') }}</a>
                        </div>

                        <div class="tw-mb-2">
                            <a href="{{ route('register') }}" class="tw-link tw-link-primary">
                                {{ __('pages/auth.login.buttons.not_registered') }}
                            </a>
                        </div>
                    </div>


                    <div class="tw-flex tw-flex-row tw-justify-center tw-items-center tw-mb-3 tw-gap-2">
                        <button type="submit"
                                class="tw-btn tw-btn-primary tw-flex-1">{{ __('pages/auth.login.buttons.login') }}</button>
                        <a href="{{ route('google.oath.login') }}"
                           class="tw-btn tw-btn-outline tw-btn-primary tw-flex-1">
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
</div>
