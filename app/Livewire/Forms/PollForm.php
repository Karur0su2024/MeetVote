<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PollForm extends Form
{
    // Název ankety
    public $title = "abc";

    // Popis ankety
    public $description;

    // Deadline ankety, po kterém nebude možné hlasovat
    public $deadline = null;

    // Nastavení ankety
    public $settings = [];

    public $user;

    // Časové možnosti
    public $dates = [];

    // Otázky ankety
    public $questions = [];


    protected $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'nullable|max:1000',
        'deadline' => 'nullable|date',
        'settings.comments' => 'boolean',
        'settings.anonymous' => 'boolean',
        'settings.hide_results' => 'boolean',
        'settings.password' => 'nullable|string',
        'settings.invite_only' => 'boolean',
        'user.name' => 'required|string|min:3|max:255',
        'user.email' => 'required|email',
        'dates' => 'required|array|min:1', // Pole různých dnů
        'dates.*.*' => 'required|array|min:1', // Časové možnosti podle data
        'dates.*.*.id' => 'nullable|integer', // ID možnosti
        'dates.*.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.*.date' => 'required', // Obsah možnosti
        'dates.*.*.content.start' => 'required_if:dates.*.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.*.content.end' => 'required_if:dates.*.*.type,time|date_format:H:i|after:dates.*.*.content.start', // Konec časové možnosti
        'dates.*.*.content.text' => 'required_if:dates.*.*.type,text|string', // Textová možnost
        'questions' => 'nullable|array', // Pole otázek
        'questions.*.id' => 'nullable|integer', // ID otázky
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.id' => 'nullable|integer', // ID možnosti
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti*/
    ];


    // Bylo použité AI pro generování všech chybových zpráv
    protected $messages = [
        'title.required' => 'The poll title is required.',
        'title.string' => 'The poll title must be a string.',
        'title.min' => 'The poll title must be at least 3 characters long.',
        'title.max' => 'The poll title must not exceed 255 characters.',
        'description.max' => 'The poll description must not exceed 1000 characters.',
        'deadline.date' => 'The deadline must be a valid date.',
        'settings.comments.boolean' => 'The comments setting must be true or false.',
        'settings.anonymous.boolean' => 'The anonymity setting must be true or false.',
        'settings.hide_results.boolean' => 'The hide results setting must be true or false.',
        'settings.password.string' => 'The password must be a string.',
        'settings.invite_only.boolean' => 'The invite-only setting must be true or false.',
        'user.name.required' => 'The user name is required.',
        'user.name.string' => 'The user name must be a string.',
        'user.name.min' => 'The user name must be at least 3 characters long.',
        'user.name.max' => 'The user name must not exceed 255 characters.',
        'user.email.required' => 'The user email is required.',
        'user.email.email' => 'The user email must be a valid email address.',
        'dates.required' => 'You must provide at least one date.',
        'dates.array' => 'The dates must be an array.',
        'dates.min' => 'You must provide at least one date.',
        'dates.*.*.required' => 'You must provide at least one time option for each date.',
        'dates.*.*.array' => 'The time options must be an array.',
        'dates.*.*.min' => 'You must provide at least one time option for each date.',
        'dates.*.*.id.integer' => 'The option ID must be an integer.',
        'dates.*.*.type.required' => 'The option type is required.',
        'dates.*.*.type.in' => 'The option type must be either time or text.',
        'dates.*.*.date.required' => 'The option date is required.',
        'dates.*.*.content.start.required_if' => 'The start time is required if the type is time.',
        'dates.*.*.content.start.date_format' => 'The start time must be in the format HH:MM.',
        'dates.*.*.content.end.required_if' => 'The end time is required if the type is time.',
        'dates.*.*.content.end.date_format' => 'The end time must be in the format HH:MM.',
        'dates.*.*.content.end.after' => 'The end time must be after the start time.',
        'dates.*.*.content.text.required_if' => 'The text option is required if the type is text.',
        'dates.*.*.content.text.string' => 'The text option must be a string.',
        'questions.array' => 'The questions must be an array.',
        'questions.*.id.integer' => 'The question ID must be an integer.',
        'questions.*.text.required' => 'The question text is required.',
        'questions.*.text.string' => 'The question text must be a string.',
        'questions.*.text.min' => 'The question text must be at least 3 characters long.',
        'questions.*.text.max' => 'The question text must not exceed 255 characters.',
        'questions.*.options.required' => 'The question options are required.',
        'questions.*.options.array' => 'The question options must be an array.',
        'questions.*.options.min' => 'The question must have at least 2 options.',
        'questions.*.options.*.id.integer' => 'The option ID must be an integer.',
        'questions.*.options.*.text.required' => 'The option text is required.',
        'questions.*.options.*.text.string' => 'The option text must be a string.',
        'questions.*.options.*.text.min' => 'The option text must be at least 3 characters long.',
        'questions.*.options.*.text.max' => 'The option text must not exceed 255 characters.',
    ];

    public function loadForm($data){
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->deadline = $data['deadline'];
        $this->settings = $data['settings'];
        $this->user = $data['user'];
        $this->dates = collect($data['time_options'])->groupBy('date')->toArray();
        ksort($this->dates);
        $this->questions = $data['questions'];
    }
}
