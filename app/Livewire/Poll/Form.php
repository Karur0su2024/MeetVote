<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;

use App\Models\TimeOption;


use App\Traits\PollForm\Options;
use App\Traits\PollForm\PollData;

use App\Services\PollService;
use App\Services\TimeOptionService;

use App\Livewire\Forms\PollForm;



class Form extends Component
{





    // Tohle přesunout do služby
    public function checkDupliciteQuestions($validatedData): bool
    {

        $this->resetErrorBag('save');

        // Kontrola duplicitních otázek
        $questions = array_map('mb_strtolower', array_column($validatedData['questions'], 'text'));

        // Porovnání všech textů otázek a unikátních textů otázek
        if (count($questions) !== count(array_unique($questions))) {
            $this->addError('save', 'Duplicate questions are not allowed.');
            return false;
        }

        // Kontrola možností
        foreach ($validatedData['questions'] as $question) {
            $options = array_map('mb_strtolower', array_column($question['options'], 'text'));
            if (count($options) !== count(array_unique($options))) {
                $this->addError('save', 'Duplicate options in a question are not allowed.');
                return false;
            }
        }

        return true;
    }






    // Metoda pro zjištění, zda nejde o duplicitní časové možnosti
    private function checkDupliciteTimeOptions($dates): bool
    {
        $this->resetErrorBag('save');

        $error = $this->timeOptionService->checkDupliciteTimeOptions($dates);

        if($error){
            $this->addError('save', $error);
            return false;
        }

        return true;
    }






    public function render()
    {
        return view('livewire.poll.form');
    }
}
