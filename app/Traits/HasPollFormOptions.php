<?php

namespace App\Traits;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Carbon\Carbon;

trait HasPollFormOptions
{
    // Časové možnosti
    #[Validate([
        'dates' => 'required|array|min:1', // Pole různých dnů
        'dates.*.date' => 'required|date', // Datum
        'dates.*.options' => 'required|array|min:1', // Časové možnosti podle data
        'dates.*.options.*.id' => 'nullable|integer', // ID možnosti
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.options.*.start' => 'required_if:options.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.options.*.end' => 'required_if:options.*.type,time|date_format:H:i|after:options.*.start', // Konec časové možnosti
        'dates.*.options.*.text' => 'required_if:options.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];

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

    // Pole odstranění existujících časových možností
    public $removedTimeOptions = [];

    // Pole odstraněných existujících otázek
    public $removedQuestions = [];

    // Pole odstraněných existujících možností otázek
    public $removedQuestionOptions = [];


    // Metoda pro přidání nového data z kalendáře
    #[On('addDate')]
    public function addDate($date)
    {
        // Kontrola, zda datum již neexistuje
        if (isset($this->dates[$date])) return;

        // Přidání nového data
        $this->dates[$date] = [
            'date' => $date,
            'options' => [],
        ];

        $this->addDateOption($date, 'time');

        // Seřazení dat podle klíče
        ksort($this->dates);
    }

    // Metoda pro odstranění data
    public function removeDate($date)
    {
        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date])) return;

        // Pokud je pouze jedno datum, nelze ho odstranit
        if (count($this->dates) == 1) return;

        // Odstranění data
        unset($this->dates[$date]);

        // Seřazení dat podle klíče
        ksort($this->dates);
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($date, $type)
    {
        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date]['options'])) return;

        // Kontrola, zda je typ možnosti časový nebo textový
        if ($type == 'time'){
            $this->addNewTimeOption($date);

        }
        else {
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
        }
        
    }

    // Metoda pro přidání nové časové možnosti
    private function addNewTimeOption($date){

        $date_options = &$this->dates[$date]['options'];
        
        // Získání posledního konce
        foreach($date_options as $option){
            if($option['type'] === 'time'){
                $last_end = Carbon::parse($option['end'])->format('H:i');
            }
        }

        // Pokud je více možností, začátek se nastaví na konec poslední časové (ne textové) možnosti
        // V případě, že neexistuje časová možnost, nastaví se na aktuální čas
        if(count($date_options) > 0){
            $start_time = isset($last_end) ?? Carbon::now()->format('H:i');
        }
        else {
            $start_time = Carbon::now()->format('H:i');
        }

        // Nastavení konce hodinu po začátku
        $end_time = Carbon::parse($start_time)->addHour()->format('H:i');

        // přidání nové časové možnosti do pole
        $date_options[] = ['type' => 'time', 'start' => $start_time, 'end' => $end_time];

    }

    // Metoda pro odstranění časových možnosti
    public function removeDateOption($dateIndex, $optionIndex)
    {

        if(isset($this->dates[$dateIndex]['options'][$optionIndex])) {
            $date_options = &$this->dates[$dateIndex]['options'];
        }
        else {
            return;
        }

        // Pokud je pouze jedna možnost, nelze ji odstranit
        if (count($date_options) == 1) return;
    
        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if(isset($date_options[$optionIndex]['id'])){

            $this->removedTimeOptions[] = $date_options[$optionIndex]['id'];
        }

        // Odstranění možnosti z pole
        unset($date_options[$optionIndex]);

        // Přeindexování možností
        $date_options = array_values($date_options);

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
        unset($question);
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

        // Pokud je má otázka pouze dvě možnosti, nelze je samostatně odstranit
        if (count($question_options) <= 2) return;

        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if(isset($question_options[$optionIndex]['id'])){
            $this->removedQuestionOptions[] = $question_options[$optionIndex]['id'];
        }

        // Odstranění možnosti
        unset($question_options[$optionIndex]);
    }
}
