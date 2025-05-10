<?php

namespace App\Livewire\Modals;

use Livewire\Component;

// Modální okno s chybovou hláškou
class Error extends Component
{

    public $errorMessage = '';

    public function mount($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function render()
    {
        return view('livewire.modals.error');
    }
}
