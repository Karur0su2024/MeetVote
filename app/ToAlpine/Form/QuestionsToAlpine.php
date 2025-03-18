<?php

namespace App\ToAlpine\Form;


// Tohle kompletně přesunout do Alpine.js
trait QuestionsToAlpine
{

        // Funkce pro přidání otázky
        public function addQuestion(): void
        {
            $this->form->questions[] = [
                'text' => '',
                'options' => [
                    [
                        'text' => '',
                    ],
                    [
                        'text' => '',

                    ],
                ],
            ];
        }


    // Funkce pro odstranění otázky
    // Vkládá se index otázky
    public function removeQuestion($questionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->form->questions[$questionIndex])) {
            $question = &$this->form->questions[$questionIndex];
        } else {
            $this->addError('form.questions', 'The selected question does not exist.');

            return;
        }

        // Pokud se jedná o existující otázku, přidat ji do pole odstraněných otázek
        if (isset($question['id'])) {
            $this->form->removed['questions'][] = $question['id'];
        }

        // Odstranění otázky z pole
        unset($this->form->questions[$questionIndex]);

        // Posunout indexy otázek
        $this->form->questions = array_values($this->form->questions);
    }

    // Funkce pro přidání možnosti otázky
    // Vkládá se index otázky
    public function addQuestionOption($questionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Kontrola, zda otázka existuje
        if (! isset($this->form->questions[$questionIndex])) {
            $this->addError('form.questions', 'The selected question not exist.');

            return;
        }

        // Přidání nové možnosti do pole otázky
        $this->form->questions[$questionIndex]['options'][] = ['text' => ''];
    }

    // Funkce pro odstranění možnosti otázky
    // Vkládá se index otázky a index odstraněné možnosti
    public function removeQuestionOption($questionIndex, $optionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Kontrola, zda otázka existuje
        if (isset($this->form->questions[$questionIndex]['options'][$optionIndex])) {
            $options = &$this->form->questions[$questionIndex]['options'];
        } else {
            $this->addError('form.questions', 'The selected option does not exist.');

            return;
        }

        // Otázka musí mít alespoň dvě možnosti
        if (count($options) <= 2) {
            $this->addError('form.questions', 'The question must have at least two options.');

            return;
        }

        // V případě, že možnost existuje, přidat ji do pole odstraněných
        if (isset($options[$optionIndex]['id'])) {
            $this->form->removed['question_options'][] = $options[$optionIndex]['id'];
        }

        unset($options[$optionIndex]);

        $options = array_values($options);
    }
}
