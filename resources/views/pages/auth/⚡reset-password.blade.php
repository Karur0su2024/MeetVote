<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Component;

new class extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.reset_password.title') }}</x-slot>

    <div class="flex justify-center items-center pt-10">
        <!-- Registrační formulář -->
        <div class="container d-flex justify-content-center align-items-center text-start pt-5">
            <div class="col-md-6">
                @if (session()->has('status'))
                    <x-ui.alert type="info">
                        {{ session('status') }}
                    </x-ui.alert>
                @endif
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">{{ __('pages/auth.reset_password.title') }}</h2>

                    <p class="text-muted">
                        {{ __('pages/auth.reset_password.description') }}
                    </p>

                    <form wire:submit="resetPassword">


                        {{-- Heslo --}}
                        <x-ui.form.input id="password" wire:model="password" type="password" label="Password" required error="password">
                            {{ __('pages/auth.reset_password.labels.password') }}
                        </x-ui.form.input>


                        {{-- Potvrzení hesla --}}
                        <x-ui.form.input id="password_confirmation" wire:model="password_confirmation" type="password" required error="password_confirmation">
                            {{ __('pages/auth.reset_password.labels.confirm_password') }}
                        </x-ui.form.input>

                        <x-ui.saving wire:loading>
                            {{ __('pages/auth.reset_password.loading') }}
                        </x-ui.saving>


                        <button class="btn btn-primary">
                            {{ __('pages/auth.reset_password.buttons.reset') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>



</x-layouts.app>
