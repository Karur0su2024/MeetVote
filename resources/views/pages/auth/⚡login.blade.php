<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

new class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.login.title') }}</x-slot>

    <div class="flex justify-center items-center pt-10">
        <div class="w-full max-w-md">
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

            <x-ui.card class="card shadow-lg bg-base-100">
                <h2 class="card-title justify-center mb-4">{{ __('pages/auth.login.title') }}</h2>
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

                    <div class="text-left flex flex-col gap-1 mb-3">
                        <x-ui.form.tw-toggle wire:model="form.remember"
                                             type="checkbox"
                                             id="remember"
                                             name="remember">
                            {{ __('pages/auth.login.labels.remember_me') }}
                        </x-ui.form.tw-toggle>
                        <div class="mb-1">
                            <a href="{{ route('password.request') }}"
                               class="link link-primary text-sm">{{ __('pages/auth.login.buttons.forgot_password') }}</a>
                        </div>

                        <div class="mb-2">
                            <a href="{{ route('register') }}" class="link link-primary text-sm">
                                {{ __('pages/auth.login.buttons.not_registered') }}
                            </a>
                        </div>
                    </div>


                    <div class="flex flex-row justify-center items-center mb-3 gap-2">
                        <button type="submit"
                                class="btn btn-primary flex-1">{{ __('pages/auth.login.buttons.login') }}</button>
                        {{--                        <a href="{{ route('google.oath.login') }}"
                                                   class="btn btn-outline btn-primary flex-1">
                                                    <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                                                </a>--}}
                        <div class="tooltip"
                             data-tip="This feature is deprecated and will be reimplemented in the future.">
                            <button class="btn btn-outline btn-disabled">
                                <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                            </button>
                        </div>
                    </div>

                    <x-ui.saving wire:loading>
                        {{ __('pages/auth.login.loading') }}
                    </x-ui.saving>
                </form>
            </x-ui.card>
        </div>
    </div>

</x-layouts.app>
