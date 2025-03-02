<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Poll;
use App\Models\TimeOption;
use App\Models\Vote;
use App\Models\VoteTimeOption;
use Illuminate\Support\Facades\Auth;

class Voting extends Component
{
    public $poll;
    public $userName;
    public $userEmail;
    public $timeOptions = [];
    public $existingVote;

    protected $rules = [
        'userName' => 'required|string|min:3|max:255',
        'userEmail' => 'required|email',
        'timeOptions.*.chosen_preference' => 'required|integer|min:-1|max:2',
    ];

    // Metoda pro načtení dat
    public function mount($poll)
    {
        $this->poll = $poll;

        $this->resetForm();

    }


    private function resetForm(){

        // Pokud je uživatel přihlášený, načteme jeho jméno a email
        if(Auth::check()){
            $this->userName = Auth::user()->name;
            $this->userEmail = Auth::user()->email;
        }
        else{
            $this->userName = '';
            $this->userEmail = '';
        }

        $this->timeOptions = [];

        // Načteme možnosti času
        foreach($this->poll->timeOptions as $timeOption){
            $this->timeOptions[$timeOption->id] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'start' => $timeOption->start,
                'text' => $timeOption->text,
                'minutes' => $timeOption->minutes,
                'chosen_preference' => 0,
            ];
        }

    }


    // Metoda pro načtení hlasu
    public function loadVote($vote)
    {
        $this->existingVote = $vote;
        $this->userName = $vote->user_name;
        $this->userEmail = $vote->user_email;

        // Načteme preference hlasu
        foreach($vote->voteTimeOptions as $voteTimeOption){
            $this->timeOptions[$voteTimeOption->time_option_id]['chosen_preference'] = $voteTimeOption->preference;
        }
    }


    // Metoda pro změnu preference časové možnosti
    public function changeTimeOptionPreference($timeOptionIndex, $value)
    {
        $this->timeOptions[$timeOptionIndex]['chosen_preference'] = $value;
    }

    //Metoda pro uložení hlasu
    public function saveVote()
    {
        $this->validate();
        // Zjištění zda uživatel vybral alespoň jednu možnost
        $hasValidVote = false;


        // Kontrola všech možností, zda mají vybranou nějakou preferenci
        foreach($this->timeOptions as $timeOption){
            if($timeOption['chosen_preference'] != 0){
                $hasValidVote = true;
                break;
            }
        }

        //Tady ještě zjisti, zda uživatel vybral alespoň jednu možnost z otázek

        // Pokud uživatel nevybral žádnou možnost, přidáme chybu
        if(!$hasValidVote){
            $this->addError('noOptionChosen', 'You have to choose at least one option.');
            return;
        }

        if($this->existingVote){
            // Aktualizace stávajícího hlasu
            $vote = $this->existingVote;

            // Smazání stávajících preferencí
            $this->existingVote->voteTimeOptions()->delete();
            $this->existingVote = null;

        }
        else {
            // Vytvoření nového hlasu
            $vote = Vote::create([
                'poll_id' => $this->poll->id,
                'user_id' => Auth::id(),
                'user_name' => $this->userName,
                'user_email' => $this->userEmail,
            ]);
        }


        // Uložení časových odpovědí do hlasu
        foreach($this->timeOptions as $timeOption){
            if($timeOption['chosen_preference'] != 0){
                $vote->voteTimeOptions()->create([
                    'time_option_id' => $timeOption['id'],
                    'preference' => $timeOption['chosen_preference'],
                ]);
            }
        }

        $this->resetForm();

    }



    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.voting');
    }
}
