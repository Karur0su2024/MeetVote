<?php

use Livewire\Component;
use App\Livewire\Forms\RegisterForm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component
{
    public RegisterForm $form;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {

        $validatedData = $this->form->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);

        event(new Registered($user = User::create($validatedData)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.register.title') }}</x-slot>

    <div class="flex justify-center items-center">
        <div class="w-full max-w-md">
            @if (session()->has('status'))
                <x-mary-alert title="{{ session('status') }}"
                              class="alert-info alert-soft"
                              icon="o-information-circle"/>
            @endif
            <div class="shadow-lg bg-base-100">
                <div class="card-body">
                    <h2 class="card-title justify-center mb-4">{{ __('pages/auth.register.title') }}</h2>
                    <form wire:submit="register">
                        <!-- Name -->
                        <x-mary-input label="{{ __('pages/auth.register.labels.name') }}"
                                      wire:model="form.name"
                                      required />

                        <!-- Email -->
                        <x-mary-input label="{{ __('pages/auth.register.labels.email') }}"
                                      wire:model="form.email"
                                      type="email"
                                      required />

                        <!-- Password -->
                        <x-mary-input label="{{ __('pages/auth.register.labels.password') }}"
                                      wire:model="form.password"
                                      type="password"
                                      required />

                        <!-- Confirm Password -->
                        <x-mary-input label="{{ __('pages/auth.register.labels.confirm_password') }}"
                                      wire:model="form.password_confirmation"
                                      type="password"
                                      required />

                        <div class="mb-3">
                            <a href="{{ route('login') }}" class="link link-primary">{{ __('pages/auth.register.buttons.already_registered') }}</a>
                        </div>

                        <div class="flex justify-center items-center mt-5 gap-2">
                            <x-mary-button label="{{ __('pages/auth.register.buttons.register') }}"
                                           type="submit"
                                           class="btn-primary grow"
                                           spinner
                            />
                            {{--                        <a href="{{ route('google.oath.login') }}" class="btn btn-outline btn-primary flex-1">
                                                        <i class="bi bi-google"></i> {{ __('pages/auth.register.buttons.with_google') }}
                                                    </a>--}}
                            <div class="tooltip" data-tip="This feature is deprecated and will be reimplemented in the future.">
                                <button class="btn btn-outline btn-disabled">
                                    <i class="bi bi-google"></i> {{ __('pages/auth.login.buttons.with_google') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>
