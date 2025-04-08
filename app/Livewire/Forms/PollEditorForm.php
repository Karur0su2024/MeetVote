<?php

namespace App\Livewire\Forms;

use App\Rules\NoDateDuplicates;
use App\Rules\NoQuestionDuplicates;
use App\Rules\NoQuestionOptionDuplicates;
use Livewire\Form;

class PollEditorForm extends Form
{
    public ?int $pollIndex = null;

    public ?string $lastUpdated = null;

    // Název ankety
    public ?string $title = '';

    // Popis ankety
    public ?string $description;

    // Deadline ankety, po kterém nebude možné hlasovat
    public ?string $deadline = null;

    // Nastavení ankety
    public array $settings = [];
    public array $password = [];

    // Informace o uživateli
    public array $user = [];

    // Časové možnosti
    public array $dates = [];

    // Otázky ankety
    public $questions = [];

    public $removed = [
        'time_options' => [],
        'questions' => [],
        'question_options' => [],
    ];

    public function rules(): array
    {
        return [
            'pollIndex' => 'nullable|integer',
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|max:1000',
            'deadline' => 'nullable|date|after:today',

            'user.posted_anonymously' => 'boolean',
            'user.name' => 'required_unless:user.posted_anonymously,string|min:3|max:255',
            'user.email' => 'required_unless:user.posted_anonymously,email',

            'dates' => 'required|array|min:1', // Pole různých dnů
            'dates.*' => ['nullable', 'array', 'min:1', new NoDateDuplicates()], // Pole časových možností podle data
            'dates.*.*.id' => 'nullable|integer', // ID možnosti
            'dates.*.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
            'dates.*.*.date' => 'required', // Obsah možnosti
            'dates.*.*.content.start' => 'required_if:dates.*.*.type,time|date_format:H:i', // Začátek časové možnosti
            'dates.*.*.content.end' => 'required_if:dates.*.*.type,time|date_format:H:i|after:dates.*.*.content.start', // Konec časové možnosti
            'dates.*.*.content.text' => 'required_if:dates.*.*.type,text|string', // Textová možnost

            'questions' => ['nullable', 'array', new NoQuestionDuplicates()], // Pole otázek
            'questions.*.id' => 'nullable|integer', // ID otázky
            'questions.*.text' => 'required|string|min:1|max:255', // Text otázky
            'questions.*.options' => ['required', 'array', 'min:2', new NoQuestionOptionDuplicates()], // Možnosti otázky
            'questions.*.options.*.id' => 'nullable|integer', // ID možnosti
            'questions.*.options.*.text' => 'required|string|min:1|max:255', // Text možnosti*/
            'removed.time_options' => 'nullable|array', // ID odstraněných časových možností
            'removed.questions' => 'nullable|array', // ID odstraněných otázek
            'removed.question_options' => 'nullable|array', // ID odstraněných možností otázek

            'settings.comments' => 'boolean',
            'settings.anonymous_votes' => 'boolean',
            'settings.hide_results' => 'boolean',
            'settings.invite_only' => 'boolean',
            'settings.add_time_options' => 'boolean',
            'settings.edit_votes' => 'boolean',
            'password.set' => 'nullable|string',
            'password.enabled' => 'boolean',
            'password.value' => 'nullable|string',
        ];
    }

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

    /**
     * @param $data
     * @return void
     */
    public function loadForm($data)
    {
        $this->lastUpdated = $data['last_updated'] ?? null;
        $this->pollIndex = $data['pollIndex'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->deadline = $data['deadline'] ?? null;
        $this->settings = $data['settings'] ?? [];
        $this->password = $data['password'] ?? null;
        $this->user = $data['user'] ?? [];
        $this->dates = collect($data['time_options'])->groupBy('date')->toArray() ?? [];
        $this->questions = $data['questions'] ?? [];

    }


    /**
     * Převede časové možnosti do samostatných položek bez data
     * @param $validatedData
     * @return array
     */
    public function prepareValidatedDataArray($validatedData): array
    {

        // Převod z dat do formátu pro uložení do databáze
        foreach ($validatedData['dates'] as $date) {
            foreach ($date as $option) {
                $validatedData['time_options'][] = $option;
            }
        }

        unset($validatedData['dates']);

        return $validatedData;
    }








}
