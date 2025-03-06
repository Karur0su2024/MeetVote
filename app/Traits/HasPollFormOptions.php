<?php

namespace App\Traits;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Carbon\Carbon;

trait HasPollFormOptions
{

    // Otázky
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
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti*/
    ])]
    public $questions = [];

    public $removedTimeOptions = [];
    public $removedQuestions = [];
    public $removedQuestionOptions = [];


    // Metoda pro přidání nového data
    #[On('addDate')]
    public function addDate($date)
    {
        // Kontrola, zda je datum vyplněné
        if (!isset($date)) return;

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
        // Pokud je pouze jedno datum, nelze ho odstranit
        if (count($this->dates) == 1) return;

        // Odstranění data
        unset($this->dates[$date]);


        //Odstanění všech možností

        // Seřazení dat podle klíče
        ksort($this->dates);
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($date, $type)
    {
        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date])) return;

        //dd($dateIndex);
        if ($type == 'time'){
            $this->addNewTimeOption($date);

        }
        else {
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
        }
        
    }

    // Metoda pro přidání nové časové možnosti
    private function addNewTimeOption($date){
        $start = Carbon::now()->format('H:i');

        // Získání posledního konce
        foreach($this->dates[$date]['options'] as $option){
            if($option['type'] == 'time'){
                $lastEnd = Carbon::parse($option['end'])->format('H:i');
            }
        }

        // Počet možností
        $optionCount = count($this->dates[$date]['options']);

        // Pokud je více možností, začátek se nastaví na konec poslední časové (ne textové) možnosti
        // V případě, že neexistuje časová možnost, nastaví se na aktuální čas
        if($optionCount > 0){
            $start = isset($lastEnd) ? Carbon::parse($lastEnd)->format('H:i') : Carbon::now()->format('H:i');
        }

        // Nastavení konce hodinu po začátku
        $end = Carbon::parse($start)->addHour()->format('H:i');

        // přidání nové časové možnosti do pole
        $this->dates[$date]['options'][] = ['type' => 'time', 'start' => $start, 'end' => $end];

    }

    // Metoda pro odstranění časových možnosti
    public function removeDateOption($dateIndex, $optionIndex)
    {
        // Pokud možnost neexistuje, nelze ji odstranit
        if (!isset($this->dates[$dateIndex]['options'][$optionIndex])) return;

        // Pokud je pouze jedna možnost, nelze ji odstranit
        if (count($this->dates[$dateIndex]['options']) == 1) return;


    
        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if(isset($this->dates[$dateIndex]['options'][$optionIndex]['id'])){

            $this->removedTimeOptions[] = $this->dates[$dateIndex]['options'][$optionIndex]['id'];
        }

        // Odstranění možnosti z pole
        unset($this->dates[$dateIndex]['options'][$optionIndex]);

        // Přeindexování možností
        $this->dates[$dateIndex]['options'] = array_values($this->dates[$dateIndex]['options']);

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
        if (!isset($this->questions[$index])) return;

        if(isset($this->questions[$index]['id'])){
            $this->removedQuestions[] = $this->questions[$index]['id'];
        }

        // Odstranění otázky
        unset($this->questions[$index]);
    }

    // Metoda pro přidání možnosti k otázce
    public function addQuestionOption($questionIndex)
    {
        // Přidání nové možnosti
        $this->questions[$questionIndex]['options'][] = ['text' => ''];
    }

    // Metoda pro odstranění možnosti k otázce
    public function removeQuestionOption($questionIndex, $optionIndex)
    {
        // Pokud je má otázka pouze dvě možnosti, nelze je samostatně odstranit
        if (count($this->questions[$questionIndex]['options']) <= 2) return;

        // Pokud možnost neexistuje, nelze ji odstranit
        if (!isset($this->questions[$questionIndex]['options'][$optionIndex])) return;

        if(isset($this->questions[$questionIndex]['options'][$optionIndex]['id'])){
            $this->removedQuestionOptions[] = $this->questions[$questionIndex]['options'][$optionIndex]['id'];
        }

        unset($this->questions[$questionIndex]['options'][$optionIndex]);
    }



}
