<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PollForm extends Form
{
    // Název ankety
    #[Validate('required', 'string', 'min:3', 'max:255')]
    public $title = "abc";

    // Popis ankety
    #[Validate('nullable', 'max:1000')]
    public $description;

    // Deadline ankety, po kterém nebude možné hlasovat
    #[Validate('nullable', 'date')]
    public $deadline = null;

    // Nastavení ankety
    #[Validate([
        'settings' => 'array', // Komentáře
        'settings.comments' => 'boolean', // Komentáře
        'settings.anonymous' => 'boolean', // Anonymní hlasování
        'settings.hide_results' => 'boolean', // Skrytí výsledků
        'settings.password' => 'nullable|string', // Heslo
        'settings.invite_only' => 'boolean', // Pouze na pozvánku
    ])]
    public $settings = [
        'comments' => true,
        'anonymous' => false,
        'hide_results' => false,
        'password' => null,
        'invite_only' => false,
    ];

    #[Validate([
        'user.name' => 'required|string|min:3|max:255', // Jméno uživatele
        'user.email' => 'required|email', // E-mail uživatele
    ])]
    public $user = [
        'name' => '',
        'email' => '',
    ];

    // Časové možnosti
    #[Validate([
        'dates' => 'required|array|min:1', // Pole různých dnů
        'dates.*.*' => 'required|array|min:1', // Časové možnosti podle data
        'dates.*.*.id' => 'nullable|integer', // ID možnosti
        'dates.*.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.*.date' => 'required', // Obsah možnosti
        'dates.*.*.content.start' => 'required_if:dates.*.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.*.content.end' => 'required_if:dates.*.*.type,time|date_format:H:i|after:dates.*.*.content.start', // Konec časové možnosti
        'dates.*.*.content.text' => 'required_if:dates.*.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];

    // Otázky
    #[Validate([
        'questions' => 'nullable|array', // Pole otázek
        'questions.*.id' => 'nullable|integer', // ID otázky
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.id' => 'nullable|integer', // ID možnosti
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti*/
    ])]
    public $questions = [];


    public function loadForm($data){
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->deadline = $data['deadline'];
        $this->settings = $data['settings'];
        $this->user = $data['user'];
        $this->dates = collect($data['time_options'])->groupBy('date')->toArray();
        $this->questions = $data['questions'];
    }



}
