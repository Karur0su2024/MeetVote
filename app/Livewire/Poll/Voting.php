<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Vote;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Traits\Poll\PollPage\Preferences;

class Voting extends Component
{

    use Preferences;

    public $poll;
    public $userName;
    public $userEmail;
    public $timeOptions = [];
    public $questions = [];
    public $existingVote;


    // Definice validací
    protected $rules = [
        'userName' => 'required|string|min:3|max:255',
        'userEmail' => 'required|email',
        'timeOptions.*.chosen_preference' => 'required|integer|min:-1|max:2',
        'questions.*.options.*.chosen_preference' => 'required|integer|in:0,2',
    ];

    // Metoda pro načtení dat
    public function mount($poll)
    {
        $this->poll = $poll;

        $this->resetForm();
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


        $this->resetOptions();
    }

    #[On('updateOptions')]
    public function updateOptions()
    {
        $this->loadOptions();
    }



    private function loadOptions()
    {
        // Načteme možnosti času
        foreach ($this->poll->timeOptions as $timeOption) {
            $this->resetOptions($timeOption);
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

                foreach ($option->votes as $vote) {
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
    public function loadVote($voteIndex): bool
    {

        $this->existingVote = Vote::find($voteIndex);

        if (!$this->existingVote) {
            return false;
        }

        $this->userName = $this->existingVote->voter_name;
        $this->userEmail = $this->existingVote->voter_email;

        // Načteme preference času
        foreach ($this->existingVote->voteTimeOptions as $vote_timeOption) {
            $this->timeOptions[$vote_timeOption->timeOption_id]['chosen_preference'] = $vote_timeOption->preference;
        }

        // Načteme preference otázek
        foreach ($this->existingVote->voteQuestionOptions as $vote_question_option) {
            $this->questions[$vote_question_option->question_id]['options'][$vote_question_option->question_option_id]['preference'] = $vote_question_option->preference;
        }

        return true;
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
        if (!$this->checkIfPreferencesWasChoosen()) {
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

        $this->dispatch('updateVotes');

        //sem dát odeslání e-mailů

        $this->resetForm();
    }


    private function checkIfPreferencesWasChoosen(): bool
    {
        $this->resetErrorBag('noOptionChosen');


        // Kontrola všech časových možností, zda mají vybranou nějakou preferenci
        foreach ($this->timeOptions as $timeOption) {
            if ($timeOption['chosen_preference'] != 0) {
                return true;
            }
        }

        // Kontrola všech možností otázek, zda mají vybranou nějakou preferenci
        foreach ($this->questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['chosen_preference'] != 0) {
                    return true;
                }
            }
        }

        $this->addError('noOptionChosen', 'You have to choose at least one option.');

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
