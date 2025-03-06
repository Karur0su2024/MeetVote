<?php

namespace App\Traits\PollForm;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;

trait Questions
{
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

    // Načtení otázek
    public function loadQuestions(){
        $questions = $this->poll->questions;

        foreach($questions as $question){
            //dd($question);
            $questionOptions = [];
            foreach($question->options as $option){
                $questionOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['text'],
                ];
            }

            $this->questions[] = [
                'id' => $question['id'],
                'text' => $question['text'],
                'options' => $questionOptions,
            ];
        }

    }


    // Metoda pro přidání otázky
    public function addQuestion()
    {
        // Přidání nové otázky s dvěma možnostmi
        $this->questions[] = [
            'text' => '',
            'options' => [
                [
                    'text' => '',
                ],
                [
                    'text' => '',
                ],
            ]
        ];
    }

    // Metoda pro odstranění otázky
    public function removeQuestion($index)
    {
        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->questions[$index])){
            $question = &$this->questions[$index];
        }
        else { 
            return; 
        }

        // Pokud otázka má ID, uloží se do pole pro odstranění
        if(isset($question['id'])){
            $this->removedQuestions[] = $question['id'];
        }

        // Odstranění otázky
        unset($this->questions[$index]);
    }

    // Metoda pro přidání možnosti k otázce
    public function addQuestionOption($questionIndex)
    {
        // Kontrola, zda otázka existuje
        if(!isset($this->questions[$questionIndex])) return;

        // Přidání nové možnosti
        $this->questions[$questionIndex]['options'][] = ['text' => ''];
    }



    // Metoda pro odstranění možnosti k otázce
    public function removeQuestionOption($questionIndex, $optionIndex)
    {
        // Kontrola, zda otázka a možnost existuje
        if(isset($this->questions[$questionIndex]['options'][$optionIndex])){
            $question_options = &$this->questions[$questionIndex]['options'];

        } else {
            return;
        }

        // Pokud je má otázka pouze dvě možnosti, nelze je smazat
        if (count($question_options) <= 2) return;

        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if(isset($question_options[$optionIndex]['id'])){
            $this->removedQuestionOptions[] = $question_options[$optionIndex]['id'];
        }

        // Odstranění možnosti
        unset($question_options[$optionIndex]);

        // Přeindexování možností
        $question_options = array_values($question_options);
    }


    public function checkDupliciteQuestions($validatedData) : bool
    {

        // Kontrola duplicitních otázek
        $questions = array_map('mb_strtolower', array_column($validatedData['questions'], 'text'));
    
        // Porovnání všech textů otázek a unikátních textů otázek
        if (count($questions) !== count(array_unique($questions))) {
            return false;
        }

        // Kontrola možností
        foreach ($validatedData['questions'] as $question) {
            $options = array_map('mb_strtolower', array_column($question['options'], 'text'));
            if (count($options) !== count(array_unique($options))) {
                return false;
            }
        }

        return true;
    }


    

    // Metoda pro uložení otázek
    private function saveQuestions($poll, $questions)
    {
        // Přidání otázek
        foreach ($questions as $question) {
            if(isset($question['id'])){
                // Aktualizace otázky, která již existuje
                $newQuestion = PollQuestion::find($question['id']);
                $newQuestion->update([
                    'text' => $question['text'],
                ]);
            }
            else {
                // Přidání nové otázky do databáze
                $newQuestion = $poll->questions()->create([
                    'text' => $question['text'],
                ]);
            }
            foreach ($question['options'] as $option) {
                $this->saveQuestionOption($newQuestion, $option);
            }
        }
    }


    // Metoda pro uložení možností otázek
    private function saveQuestionOption($question, $option)
    {
        if(isset($option['id'])){
            // Aktualizace možnosti, která již existuje
            $newOption = QuestionOption::find($option['id']);
            $newOption->update([
                'text' => $option['text'],
            ]);
        }
        else {
            // Přidání nové možnosti do databáze
            $question->options()->create([
                'text' => $option['text'],
            ]);
        }
    }
}
