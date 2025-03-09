<?php

namespace App\Services;

use App\Models\Poll;
use Carbon\Carbon;
use App\Models\TimeOption;

class TimeOptionService
{


    // Metoda pro načtení časových možností ankety
    // Pokud není anketa nastavena, vrátí dvě časové možnosti
    // Pokud je anketa nastavena, vrátí pole časových možností ankety
    public function getPollTimeOptions(?Poll $poll) : array
    {
        $timeOptions = [];

        if(!Poll::where('id', $poll->id)->first()) {
            $timeOptions[] = $this->addNewOption(Carbon::today()->format('Y-m-d'), 'time', null);

            return $timeOptions;
        }

        foreach ($poll->timeOptions as $timeOption) {
            $timeOptions[] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'type' => $timeOption->start ? 'time' : 'text',
                'content' => $timeOption->start ? [
                    'start' => Carbon::parse($timeOption->start)->format('H:i'),
                    'end' => Carbon::parse($timeOption->start)->addMinutes($timeOption->minutes)->format('H:i'),
                ] : [
                    'text' => $timeOption->text,
                ],
                'chosen_preference' => 0,
            ];
        }
        return $timeOptions;


    }


    // Metoda pro smazání existujících časových možností
    public function deleteTimeOptions(array $deletedOptions) : void
    {
        TimeOption::whereIn('id', $deletedOptions)->delete();
    }



    // Metoda pro uložení časových možností do databáze
    // Pokud časová možnost již existuje, aktualizuje ji
    // Pokud časová možnost neexistuje, vytvoří ji
    public function saveTimeOptions(Poll $poll, array $timeOptions) : bool
    {
        foreach($timeOptions as $option) {

            $minutes = isset($option['content']['start']) && isset($option['content']['end'])
            ? Carbon::parse($option['content']['start'])->diffInMinutes($option['content']['end'])
            : null;


            $optionToAdd = [
                'date' => $option['date'],
                'text' => $option['content']['text'] ?? null,
                'start' => $option['content']['start'] ?? null,
                'minutes' => $minutes,
            ];

            if(isset($option['id'])){
                $poll->timeOptions()->where('id', $option['id'])->update($optionToAdd);
            }
            else{
                $poll->timeOptions()->create($optionToAdd);
            }


        }

        return true;
    }


    // Metoda pro přidání nové možnosti do pole
    public function addNewOption(String $date, String $type, ?String $lastEnd) : array
    {
        if($type === 'text'){
            $content = [
                'text' => '',
            ];
        }
        else {
            $content = $this->addNewTimeOption($lastEnd);
        }

        return [
            'type' => $type,
            'date' => $date,
            'content' => $content
        ];
    }




    // Metoda pro přidání nové možnosti do pole typu čas
    public function addNewTimeOption(?String $lastEnd) : array
    {
        if($lastEnd){
            return [
                'start' => $lastEnd,
                'end' => $this->getEndOfTimeOption($lastEnd, 60),
            ];
        }
        else {
            return [
                'start' => Carbon::now()->format('H:i'),
                'end' => Carbon::now()->addHour()->format('H:i'),
            ];
        }
    }



    // Kontrola, zda nejsou v časových možnostech duplicity
    // Pokud ano, vrátí true
    public function checkDuplicity(Array $options): bool
    {
        $toCheck = array_map(function ($item) {
            return $this->convertContentToText($item);
        }, $options);

        return count($options) !== count(array_unique($toCheck));

    }

    // Metoda pro převod konce časové možnosti
    private function getEndOfTimeOption(String $start, int $minutes){
        return Carbon::parse($start)->addMinutes($minutes)->format('H:i');
    }


    // Metoda pro převod časové možnosti na textovou podobu pro kontrolu duplicity
    private function convertContentToText($option) : string
    {
        return $option['date'] . ' ' . strtolower(implode('-', $option['content']));

    }



    // Přesunout do služby
    public function getLastEnd(array $date): ?string
    {
        $endTime = null;

        if (isset($date)) {
            foreach ($date as $options) {
                if (isset($options['content']['end'])) {
                    $endTime = $options['content']['end'];
                }
            }
        }

        return $endTime;
    }




}
