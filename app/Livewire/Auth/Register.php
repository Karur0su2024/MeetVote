<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
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

    public function render()
    {
        return view('livewire.auth.register');
    }

}
