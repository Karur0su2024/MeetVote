<?php

namespace App\Traits\PollForm;

use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\TimeOption;

trait TimeOptions
{
    // Časové možnosti
    #[Validate([
        'dates' => 'required|array|min:1', // Pole různých dnů
        'dates.*.date' => 'required|date', // Datum
        'dates.*.options' => 'required|array|min:1', // Časové možnosti podle data
        'dates.*.options.*.id' => 'nullable|integer', // ID možnosti
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.options.*.start' => 'required_if:options.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.options.*.end' => 'required_if:options.*.type,time|date_format:H:i|after:dates.*.options.*.start', // Konec časové možnosti
        'dates.*.options.*.text' => 'required_if:options.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];


    // Metoda pro načtení časových možností
    public function loadTimeOptions()
    {
        $dates = $this->poll->timeOptions->groupBy('date')->toArray();

        foreach ($dates as $dateIndex => $options) {
            $timeOptions = [];
            foreach ($options as $option) {
                if ($option['start'] != null) {
                    $timeOptions[] = [
                        'id' => $option['id'],
                        'type' => 'time',
                        'start' => Carbon::parse($option['start'])->format('H:i'),
                        'end' => Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i'),
                    ];
                } else {
                    $timeOptions[] = [
                        'id' => $option['id'],
                        'type' => 'text',
                        'text' => $option['text'],
                    ];
                }
            }

            $this->dates[$dateIndex] = [
                'date' => $dateIndex,
                'options' => $timeOptions,
            ];
        }
        //dd($this->dates);

    }




    // Metoda pro přidání nového data z kalendáře
    #[On('addDate')]
    public function addDate($date) : bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum již neexistuje
        if (isset($this->dates[$date])) {
            $this->addError('dates', 'This date has already been added.');
            return false;
        }

        // Kontrola, zda datum není v minulosti
        $is_not_past = Carbon::parse($date)->isToday() || Carbon::parse($date)->isFuture();

        // Pokud je datum v minulosti, nelze ho přidat
        if (!$is_not_past) {
            $this->addError('dates', 'You cannot add a date in the past.');
            return false;
        }

        // Přidání nového data
        $this->dates[$date] = [
            'date' => $date,
            'options' => [],
        ];

        $this->addDateOption($date, 'time');


        // Seřazení dat podle klíče
        ksort($this->dates);

        return true;
    }

    // Metoda pro odstranění data
    public function removeDate($date): bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date])) {
            $this->addError('dates', 'The selected date does not exist.');
            return false;
        }

        // Pokud je pouze jedno datum, nelze ho odstranit
        if (count($this->dates) == 1) {
            $this->addError('dates', 'At least one date must remain.');
            return false;
        }

        // Odstranění data
        unset($this->dates[$date]);

        // Seřazení dat podle klíče
        ksort($this->dates);


        return true;
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($date, $type) : bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date]['options'])) {

            $this->addError('dates', 'The selected date does not exist.');
            return false;
        }

        // Kontrola, zda je typ možnosti časový nebo textový
        if ($type == 'time') {
            $this->addNewTimeOption($date);
        } else {
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
        }

        return true;
    }

    // Metoda pro přidání nové časové možnosti
    private function addNewTimeOption($date) : bool
    {

        $date_options = &$this->dates[$date]['options'];
        $start_time = Carbon::now()->format('H:i');

        // Získání posledního konce
        foreach ($date_options as $option) {
            if ($option['type'] === 'time') {
                $start_time = Carbon::parse($option['end'])->format('H:i');
            }
        }

        // Nastavení konce hodinu po začátku
        $end_time = Carbon::parse($start_time)->addHour()->format('H:i');

        // přidání nové časové možnosti do pole
        $date_options[] = ['type' => 'time', 'start' => $start_time, 'end' => $end_time];

        return true;
    }

    // Metoda pro odstranění časových možnosti
    public function removeDateOption($dateIndex, $optionIndex) : bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum a možnost existuje
        if (isset($this->dates[$dateIndex]['options'][$optionIndex])) {
            $date_options = &$this->dates[$dateIndex]['options'];
        } else {
            $this->resetErrorBag('dates');
            $this->addError('dates', 'The selected time option does not exist.');
            return false;
        }

        // Pokud je pouze jedna možnost, nelze ji odstranit
        if (count($date_options) == 1) {
            if (!$this->removeDate($dateIndex)) {
                $this->addError('dates', 'At least one time option must remain.');
                return false;
            }
        }


        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if (isset($date_options[$optionIndex]['id'])) {

            $this->removedTimeOptions[] = $date_options[$optionIndex]['id'];
        }

        // Odstranění možnosti z pole
        unset($date_options[$optionIndex]);

        // Přeindexování možností
        $date_options = array_values($date_options);

        return true;
    }



    private function checkDupliciteTimeOptions($dates): bool
    {
        $this->resetErrorBag('save');

        foreach ($dates as $date) {
            $optionContent = [];

            // Načtení všech možností v textové podobě podobě
            foreach ($date['options'] as $option) {
                $optionContent[] = $this->convertTimeOptionToText($option);
            }

            // Porovnání všech termínů a unikátních termínů
            if (count($optionContent) !== count(array_unique($optionContent))) {
                $this->addError('save', 'Duplicate time options are not allowed.');
                return false;
            }
        }


        return true;
    }


    // Metoda pro uložení časových možností
    private function saveTimeOptions($poll, $dates) : bool
    {
        $this->resetErrorBag('save');
        foreach ($dates as $date) {
            foreach ($date['options'] as $option) {
                if ($option['type'] == 'time') {
                    $minutes = Carbon::parse($option['start'])->diffInMinutes($option['end']);
                    //dd($option);

                    if (isset($option['id'])) {
                        // Aktualizace časové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        if(!$newOption){
                            $this->addError('save', 'Failed to update: Time option not found.');
                            return false;
                        }
                        $newOption->update([
                            'start' => $date['date'] . ' ' . $option['start'],
                            'minutes' => $minutes
                        ]);
                    } else {
                        //dd($option);
                        // Přidání nové časové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'start' => $option['start'],
                            'minutes' => $minutes
                        ]);
                    }
                } else {

                    if (isset($option['id'])) {
                        // Aktualizace textové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        if(!$newOption){
                            $this->addError('save', 'Failed to update: Time option not found.');
                            return false;
                        }
                        $newOption->update([
                            'text' => $option['text'],
                        ]);
                    } else {
                        // Přidání textové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'text' => $option['text'],
                        ]);
                    }
                }
            }
        }

        return true;
    }


    // Metoda pro konverzi časové možnosti na textovou podobu
    private function convertTimeOptionToText($option)
    {
        if ($option['type'] == 'time') {
            return strtolower($option['start'] . '-' . $option['end']);
        } else {
            return strtolower($option['text'] . '-text');
        }
    }
}
