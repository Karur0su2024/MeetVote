<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class VotingForm extends Form
{
    public $poll;

    // Uživatelské jméno a email
    public $user = [
        'name' => '',
        'email' => '',
    ];

    // Časové možnosti
    public $timeOptions = [];

    // Možnosti otázek
    public $questions = [];

    //
    public $existingVote;

    // Definice validací
    protected $rules = [
        'user.name' => 'required|string|min:3|max:255',
        'user.email' => 'required|email',
        'existingVote' => 'nullable|integer',
        'timeOptions.*.picked_preference' => 'required|integer|min:-1|max:2',
        'timeOptions.*.id' => 'required|integer',
        'questions.*.id' => 'required|integer',
        'questions.*.options.*.id' => 'required|integer',
        'questions.*.options.*.picked_preference' => 'required|integer|in:0,1',
    ];

    public function loadData($data)
    {

        if (Auth::check()) {
            $this->user['name'] = Auth::user()->name;
            $this->user['email'] = Auth::user()->email;
        } else {
            $this->user['name'] = $data['user']['name'] ?? '';
            $this->user['email'] = $data['user']['email'] ?? '';
        }

        $this->timeOptions = $data['time_options'];
        $this->questions = $data['questions'];
        $this->existingVote = null;
    }
}
