<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Livewire\Forms\RegisterForm;

class Register extends Component
{
    public RegisterForm $form;

    public function render()
    {
        return view('livewire.pages.auth.register')->layout('layouts.app', ['padding' => '5']);;
    }

    public function register(): void
    {
        $validated = $this->form->validate();

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
