<?php

namespace App\Traits\PollForm;

use App\Models\TimeOption;
use App\Models\PollQuestion;
use App\Models\QuestionOption;


trait Options
{

    // Trait obsahující logiku pro časové možnosti
    use Questions;

    // Trait obsahující logiku pro otázky
    use TimeOptions;

    // Pole odstranění existujících časových možností
    public $removedTimeOptions = [];

    // Pole odstraněných existujících otázek
    public $removedQuestions = [];

    // Pole odstraněných existujících možností otázek
    public $removedQuestionOptions = [];


    // Metoda pro kontrolu duplicit jednotlivých možností
    private function checkDuplicate($validatedData): bool
    {
        // kontrola duplicitních termínů
        if (!$this->checkDupliciteTimeOptions($validatedData['dates'])) {
            return false;
        }

        if (!$this->checkDupliciteQuestions($validatedData)) {
            return false;
        }

        return true;
    }

    // Metoda pro uložení časových možností a možností otázek
    private function saveOptions($poll, $validatedData)
    {
        $this->saveTimeOptions($poll, $validatedData['dates']);
        $this->saveQuestions($poll, $validatedData['questions']);
    }

    private function removeDeletedOptions(){
        foreach($this->removedTimeOptions as $optionIndex){
            $option = TimeOption::find($optionIndex);
            $option->delete();
        }

        foreach($this->removedQuestionOptions as $optionIndex){
            $option = QuestionOption::find($optionIndex);
            $option->delete();
        }

        foreach($this->removedQuestions as $questionIndex){
            $question = PollQuestion::find($questionIndex);
            $question->delete();
        }
    }
}
