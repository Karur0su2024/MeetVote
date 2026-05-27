<?php

use Illuminate\Support\Facades\Password;
use Livewire\Component;

new class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        // If the password broker returns a status that is not a success, we will
        // add the error to the email field. Otherwise, we will reset the email
        // field and flash a success message to the session.
        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
};
?>

<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.forgot_password.title') }}d</x-slot>

    <x-ui.card class="w-full max-w-md mx-auto">
        {{-- Formulář pro obnovení hesla --}}
        @if (session()->has('status'))
            <x-ui.alert type="info">
                {{ session('status') }}
            </x-ui.alert>
        @endif
        <h2 class="text-lg text-center mb-2">{{ __('pages/auth.forgot_password.title') }}</h2>

        <p class="text-sm font-light text-gray-500 mb-4">
            {{ __('pages/auth.forgot_password.description') }}
        </p>

        <form wire:submit.prevent="sendPasswordResetLink">

            <!-- Email -->
            <x-mary-input id="email"
                          wire:model="email"
                          type="email"
                          label="{{ __('pages/auth.forgot_password.labels.email') }}"
                          required />

            <div class="flex">
                <x-mary-button class="btn-primary mt-3"
                               type="submit"
                               label="{{ __('pages/auth.forgot_password.buttons.send') }}"/>
                <x-mary-loading wire:loading />
            </div>
        </form>
    </x-ui.card>

</x-layouts.app>
