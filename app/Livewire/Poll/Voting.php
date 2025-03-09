<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\VotingForm;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Voting extends Component
{


    // Tohle tady může zůstat
    #[On('updateOptions')]
    public function updateOptions()
    {
        $this->loadOptions();
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

    // Přesunout do služby
    // Metoda pro uložení hlasu
    public function saveVote()
    {
        // Validace formuláře
        $this->validate();

        $this->voteService->saveVote(
            $this->poll,
            $this->userName,
            $this->userEmail,
            $this->timeOptions,
            $this->questions,
            $this->existingVote
        );

        // Zjištění zda uživatel vybral alespoň jednu možnost
        if (! $this->checkIfPreferencesWasChoosen()) {
            $this->addError('noOptionChosen', 'You have to choose at least one option.');

            return;
        }

        $vote = $this->voteService->saveVote(
            $this->poll,
            $this->userName,
            $this->userEmail,
            $this->timeOptions,
            $this->questions,
            $this->existingVote
        );

        $this->dispatch('updateVotes');

        // sem dát odeslání e-mailů

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



    // Metoda pro modalového okna výsledků ankety
    public function openResultsModal()
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.results',
            'params' => [
                'publicIndex' => $this->poll->public_id,
            ],

        ]);
    }

    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.voting');
    }







    // -----------------------------------------------------------------------------------------------------

    // Tohle bylo ve službě




}
