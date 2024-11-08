<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Livewire\Forms\PollSettingForm;

class PollSettings extends Component {

    public PollSettingForm $form;

    public function render()
    {
        return view('livewire.pages.poll-settings')->layout('layouts.app', ['padding' => '5']);
    }

    public function savePollSettings()
    {
        $info = $this->validate();

        session(['poll' => $info]);
        return $this->redirectRoute('polls.new.questions');
    }


}
