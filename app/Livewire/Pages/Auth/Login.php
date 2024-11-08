<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

class Login extends Component
{

    public LoginForm $form;

    public function render()
    {
        return view('livewire.pages.auth.login')->layout('layouts.app', ['padding' => '5']);
    }

    public function login(): void
    {

        $this->validate();

        $this->form->authenticate();
        
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}
