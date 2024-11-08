<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;

class RegisterForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $username = '';

    #[Validate('required|string|lowercase|email|max:255|unique:'.User::class)]
    public string $email = '';

    #[Validate('required|string|confirmed', 'password')]
    public string $password = '';

    public string $password_confirmation = '';

}
