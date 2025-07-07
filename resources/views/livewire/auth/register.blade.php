<div class="tw-flex tw-justify-center tw-items-center tw-pt-10">
    <div class="tw-w-full tw-max-w-md">
        @if (session()->has('status'))
            <x-ui.alert type="info">
                {{ session('status') }}
            </x-ui.alert>
        @endif
        <div class="tw-shadow-lg tw-bg-base-100">
            <div class="tw-card-body">
                <h2 class="tw-card-title card-title tw-justify-center tw-mb-4">{{ __('pages/auth.register.title') }}</h2>
                <form wire:submit="register">
                    <!-- Name -->
                    <x-ui.form.tw-input id="name" wire:model="form.name" type="text" required error="form.name">
                        <x-slot:label>
                            {{ __('pages/auth.register.labels.name') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>

                    <!-- Email -->
                    <x-ui.form.tw-input id="email" wire:model="form.email" type="email" required error="form.email">
                        <x-slot:label>
                            {{ __('pages/auth.register.labels.email') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>
                    <!-- Password -->
                    <x-ui.form.tw-input id="password" wire:model="form.password" type="password" required error="form.password">
                        <x-slot:label>
                            {{ __('pages/auth.register.labels.password') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>

                    <!-- Confirm Password -->
                    <x-ui.form.tw-input id="password_confirmation" wire:model="form.password_confirmation" type="password" required  error="form.password_confirmation">
                        <x-slot:label>
                            {{ __('pages/auth.register.labels.confirm_password') }}
                        </x-slot:label>
                    </x-ui.form.tw-input>

                    <div class="tw-mb-3">
                        <a href="{{ route('login') }}" class="tw-link tw-link-primary">{{ __('pages/auth.register.buttons.already_registered') }}</a>
                    </div>

                    <div class="tw-flex tw-justify-center tw-items-center tw-mb-3 tw-gap-2">
                        <button type="submit" class="tw-btn tw-btn-primary tw-flex-1">{{ __('pages/auth.register.buttons.register') }}</button>
                        <a href="{{ route('google.oath.login') }}" class="tw-btn tw-btn-outline tw-btn-primary tw-flex-1">
                            <i class="bi bi-google"></i> {{ __('pages/auth.register.buttons.with_google') }}
                        </a>
                    </div>
                    <x-ui.saving wire:loading>
                        {{ __('pages/auth.register.loading') }}
                    </x-ui.saving>
                </form>
            </div>
        </div>
    </div>
</div>
