<?php

namespace App\Livewire\Forms\PollEditor;

use App\Rules\NoDateDuplicates;
use App\Rules\NoQuestionDuplicates;
use App\Rules\NoQuestionOptionDuplicates;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InfoSection extends Form
{
    public ?int $pollIndex = null;

    // Název ankety
    public ?string $title = '';

    // Popis ankety
    public ?string $description;

    // Deadline ankety, po kterém nebude možné hlasovat
    public ?string $deadline = null;

    public ?string $timezone;

    public array $user = [];


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
        ];
    }
}
