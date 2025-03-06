<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Vote;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Voting extends Component
{
    public $poll;
    public $userName;
    public $userEmail;
    public $timeOptions = [];
    public $questions = [];
    public $existingVote;
    public $preferences = [];

    // Definice validací
    protected $rules = [
        'userName' => 'required|string|min:3|max:255',
        'userEmail' => 'required|email',
        'timeOptions.*.chosen_preference' => 'required|integer|min:-1|max:2',
        'questions.*.options.*.chosen_preference' => 'required|integer|min:-1|max:2',
    ];

    // Metoda pro načtení dat
    public function mount($poll)
    {
        $this->poll = $poll;

        $this->preferences = [
            '2' => [
                'value' => 2,
                'text' => 'yes',
            ],
            '1' => [
                'value' => 1,
                'text' => 'maybe',
            ],
            '-1' => [
                'value' => -1,
                'text' => 'no',
            ],
            '0' => [
                'value' => 0,
                'text' => 'none',
            ],
        ];

        $this->resetForm();
    }


    public function changeTimePreference($optionIndex)
    {
        switch($this->timeOptions[$optionIndex]['chosen_preference']) {
            case 0:
                $this->timeOptions[$optionIndex]['chosen_preference'] = 2;
                break;
            case 2:
                $this->timeOptions[$optionIndex]['chosen_preference'] = 1;
                break;
            case 1:
                $this->timeOptions[$optionIndex]['chosen_preference'] = -1;
                break;
            case -1:
                $this->timeOptions[$optionIndex]['chosen_preference'] = 0;
                break;
        }

    }

    public function changeQuestionPreference($questionIndex, $optionIndex)
    {
        switch($this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference']) {
            case 0:
                $this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference'] = 2;
                break;
            case 2:
                $this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference'] = 0;
                break;
        }
    }

    // Metoda pro resetování formuláře
    private function resetForm()
    {
        // Pokud je uživatel přihlášený, načteme jeho jméno a email
        if (Auth::check()) {
            $this->userName = Auth::user()->name;
            $this->userEmail = Auth::user()->email;
        } else {
            $this->userName = '';
            $this->userEmail = '';
        }

        // Resetování možností času a otázek
        $this->timeOptions = [];
        $this->questions = [];

        // Načteme možnosti času
        foreach ($this->poll->timeOptions as $timeOption) {
            $votes = [
                'yes' => 0,
                'maybe' => 0,
                'no' => 0,
                'total' => 0,
            ];

            foreach($timeOption->votes as $vote) {
                switch ($vote->preference) {
                    case 2:
                        $votes['yes']++;
                        $votes['total'] = $votes['total'] + 2;
                        break;
                    case 1:
                        $votes['maybe']++;
                        $votes['total'] = $votes['total'] + 1;
                        break;
                    case -1:
                        $votes['no']++;
                        $votes['total'] = $votes['total'] - 1;
                        break;
                }
                
            }



            $this->timeOptions[$timeOption->id] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'start' => $timeOption->start,
                'text' => $timeOption->text,
                'minutes' => $timeOption->minutes,
                'chosen_preference' => 0,
                'votes' => $votes,
            ];
        }

        // Načteme otázky
        foreach ($this->poll->questions as $question) {
            $this->questions[$question->id] = [
                'id' => $question->id,
                'text' => $question->text,
                'options' => [],
            ];

            foreach ($question->options as $option) {
                $votes = [
                    'yes' => 0,
                ];

                foreach($option->votes as $vote) {
                    $votes['yes']++;
                }

                $this->questions[$question->id]['options'][$option->id] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'chosen_preference' => 0,
                    'votes' => $votes, 
                ];
            }
        }
    }


    // Metoda pro načtení hlasu
    #[On('loadVote')]
    public function loadVote($voteIndex)
    {
        // Načteme hlas
        

        $this->existingVote = Vote::find($voteIndex);
        //dd($this->existingVote);
        $this->userName = $this->existingVote->voter_name;
        $this->userEmail = $this->existingVote->voter_email;

        // Načteme preference času
        foreach ($this->existingVote->voteTimeOptions as $voteTimeOption) {
            $this->timeOptions[$voteTimeOption->time_option_id]['chosen_preference'] = $voteTimeOption->preference;
        }

        // Načteme preference otázek
        foreach ($this->existingVote->voteQuestionOptions as $voteQuestionOption) {
            $this->questions[$voteQuestionOption->question_id]['options'][$voteQuestionOption->question_option_id]['preference'] = $voteQuestionOption->preference;
        }
    }


    // Metoda pro změnu preference časové možnosti
    public function changeTimeOptionPreference($timeOptionIndex, $value)
    {
        $this->timeOptions[$timeOptionIndex]['chosen_preference'] = $value;
    }

    // Metoda pro změnu preference možnosti otázky
    public function changeQuestionOptionPreference($questionIndex, $optionIndex, $value)
    {
        $this->questions[$questionIndex]['options'][$optionIndex]['chosen_preference'] = $value;
    }

    //Metoda pro uložení hlasu
    public function saveVote()
    {
        // Validace formuláře
        $this->validate();
        

        // Zjištění zda uživatel vybral alespoň jednu možnost
        if (!$this->checkIfPreferencesWasChoosen())
        {
            $this->addError('noOptionChosen', 'You have to choose at least one option.');
            return;
        }


        if ($this->existingVote) {
            // Aktualizace stávajícího hlasu
            $vote = $this->existingVote;

            // Smazání stávajících preferencí
            $this->existingVote->voteTimeOptions()->delete();
            $this->existingVote = null;
        } else {
            // Vytvoření nového hlasu
            $vote = Vote::create([
                'poll_id' => $this->poll->id,
                'user_id' => Auth::id(),
                'voter_name' => $this->userName,
                'voter_email' => $this->userEmail,
            ]);
        }


        // Uložení jednotlivých možností do databáze
        $this->saveOptionsToDatabase($vote);

        //sem dát odeslání e-mailů

        $this->resetForm();
    }


    private function checkIfPreferencesWasChoosen(): bool
    {
        // Kontrola všech časových možností, zda mají vybranou nějakou preferenci
        foreach ($this->timeOptions as $timeOption) {
            if ($timeOption['chosen_preference'] != 0) {
                return true;
                break;
            }
        }

        // Kontrola všech možností otázek, zda mají vybranou nějakou preferenci
        foreach ($this->questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['chosen_preference'] != 0) {
                    return true;
                    break;
                }
            }
        }

        return false;
    }


    private function saveOptionsToDatabase($vote = null)
    {
        // Uložení časových odpovědí do hlasu
        foreach ($this->timeOptions as $timeOption) {
            if ($timeOption['chosen_preference'] != 0) {
                $vote->voteTimeOptions()->create([
                    'time_option_id' => $timeOption['id'],
                    'preference' => $timeOption['chosen_preference'],
                ]);
            }
        }

        // Uložení otázek do hlasu
        foreach ($this->questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['chosen_preference'] != 0) {
                    $vote->voteQuestionOptions()->create([
                        'poll_question_id' => $question['id'],
                        'question_option_id' => $option['id'],
                        'preference' => $option['chosen_preference'],
                    ]);
                }
            }
        }
    }


    // Metoda pro odeslání emailů
    private function sendEmails($vote)
    {
        // zatím neimplementováno
    }


    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.voting');
    }
}
