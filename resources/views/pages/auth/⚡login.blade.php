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
                <x-mary-alert title="{{ session('status') }}"
                              class="alert-info alert-soft"
                              icon="o-information-circle"/>
            @endif
            @if(session('error'))
                <x-mary-alert title="{{ session('error') }}"
                              class="alert-error alert-soft"
                              icon="o-information-circle"/>
            @endif

            <x-ui.card>
                <h2 class="card-title justify-center mb-4">{{ __('pages/auth.login.title') }}</h2>
                <form wire:submit="login">
                    @csrf
                    <x-mary-input label="{{ __('pages/auth.login.labels.email') }}"
                                  wire:model="form.email"
                                  type="email"
                                  required/>

                    <x-mary-input label="{{ __('pages/auth.login.labels.password') }}"
                                  wire:model="form.password"
                                  type="password"
                                  required/>
                    <div class="text-left flex flex-col gap-1 mb-3">
                        <x-mary-toggle label="{{ __('pages/auth.login.labels.remember_me') }}"
                                       class="toggle-primary toggle-sm"
                                       wire:model="form.remember"/>
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
                        <x-mary-button label="{{ __('pages/auth.login.buttons.login') }}"
                                       type="submit"
                                       class="btn-primary grow"
                                       spinner
                        />

                        {{--                        <a href="{{ route('google.oath.login') }}"
                                                   class="btn btn-outline btn-primary flex-1">
                                                    <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                                                </a>--}}
                        <div class="tooltip"
                             data-tip="This feature is deprecated and will be reimplemented in the future.">
                            <button class="btn btn-outline btn-disabled grow">
                                <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                            </button>
                        </div>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>

</x-layouts.app>
