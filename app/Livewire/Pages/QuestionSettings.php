<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class QuestionSettings extends Component
{
    public function render()
    {
        return view('livewire.pages.question-settings')->layout('layouts.app', ['padding' => '5']);
    }
}
