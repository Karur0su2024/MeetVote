<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PollSettingForm extends Form
{
    #[Validate('required|string|min:3|max:50')]
    public $title;

    #[Validate('nullable|string|max:512')]
    public $description;

    #[Validate('required|string|min:3|max:50')]
    public $username;

    #[Validate('required|email')]
    public $email;

}
