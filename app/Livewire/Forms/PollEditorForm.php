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

    public string $timezone;

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
            'pollIndex' => 'nullable|integer', // Index ankety, pokul je upravována
            'title' => 'required|string|min:3|max:255', // Název ankety
            'description' => 'nullable|max:1000', // Popis ankety
            'deadline' => 'nullable|date|after:today', // Uzávěrka ankety
            'timezone' => 'nullable|string', // Časové pásmo ankety

            'user.name' => 'required|string|min:3|max:255', // Jméno uživatele
            'user.email' => 'required|email', // E-mail uživatele

            'dates' => 'required|array|min:1', // Pole různých dnů
            'dates.*' => ['nullable', 'array', 'min:1', new NoDateDuplicates()], // Pole časových možností podle data
            'dates.*.*.id' => 'nullable|integer', // ID možnosti
            'dates.*.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
            'dates.*.*.date' => 'required', // Obsah možnosti
            'dates.*.*.content.start' => 'required_if:dates.*.*.type,time|date_format:H:i', // Začátek časové možnosti
            'dates.*.*.content.end' => 'required_if:dates.*.*.type,time|date_format:H:i|after:dates.*.*.content.start', // Konec časové možnosti
            'dates.*.*.content.text' => 'required_if:dates.*.*.type,text|string', // Textová možnost
            'dates.*.*.score' => 'nullable|int',// Text možnosti*/

            'questions' => ['nullable', 'array', new NoQuestionDuplicates()], // Pole otázek
            'questions.*.id' => 'nullable|integer', // ID otázky
            'questions.*.text' => 'required|string|min:1|max:255', // Text otázky
            'questions.*.options' => ['required', 'array', 'min:2', new NoQuestionOptionDuplicates()], // Možnosti otázky
            'questions.*.options.*.id' => 'nullable|integer', // ID možnosti
            'questions.*.options.*.text' => 'required|string|min:1|max:255',
            'questions.*.options.*.score' => 'nullable|int',// Text možnosti*/
            'removed.time_options' => 'nullable|array', // ID odstraněných časových možností
            'removed.questions' => 'nullable|array', // ID odstraněných otázek
            'removed.question_options' => 'nullable|array', // ID odstraněných možností otázek

            'settings' => 'nullable|array', // Nastavení ankety
            'settings.comments' => 'required|boolean',
            'settings.anonymous_votes' => 'required|boolean',
            'settings.hide_results' => 'required|boolean',
            'settings.invite_only' => 'required|boolean',
            'settings.add_time_options' => 'required|boolean',

            'password.set' => 'nullable|string',
            'password.enabled' => 'boolean',
            'password.value' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'dates.*.*.content.start.required_if' => __('pages/poll-editor.time_options.error_messages.empty_start'),
            'dates.*.*.content.start.date_format' => __('pages/poll-editor.time_options.error_messages.format_start'),
            'dates.*.*.content.end.required_if' => __('pages/poll-editor.time_options.error_messages.empty_end'),
            'dates.*.*.content.end.date_format' => __('pages/poll-editor.time_options.error_messages.format_end'),
            'dates.*.*.content.end.after' => __('pages/poll-editor.time_options.error_messages.after_start'),

            'dates.*.*.content.text.required_if' => __('pages/poll-editor.time_options.error_messages.empty_text'),
        ];
    }

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
        $this->timezone = $data['timezone'] ?? config('app.timezone');
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
