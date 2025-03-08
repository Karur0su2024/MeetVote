<?php

namespace App\Services;

use App\Models\Poll;
use Carbon\Carbon;
use App\Models\TimeOption;

class TimeOptionService
{
    public function getTimeOptionsForPoll(?Poll $poll) : array
    {
        $timeOptions = [];
        if(!$poll){
            $timeOptions[] = $this->addNewTimeOption(Carbon::today()->format('Y-m-d'), null);
            $timeOptions[] = $this->addNewTimeOption(Carbon::tomorrow()->addDay()->format('Y-m-d'), null);
            return $timeOptions;
        }


        foreach ($poll->timeOptions as $timeOption) {
            $timeOptions[] = [
                'id' => $timeOption->id,
                'start_time' => $timeOption->start_time,
                'end_time' => $timeOption->end_time,
                'chosen_preference' => 0,
            ];
        }
        return $timeOptions;
    }


    // Metoda pro vytvoření nové časové možnosti do pole
    public function addNewOption($date, $content, $lastEnd = null) : array
    {
        //return $this->addNewTimeOption($date, $lastEnd);


        if($start){
            $content = [
                'start' => $start,
                'end' => $this->getEndOfTimeOption($start, 60),
            ];
        }
        else {
            $content = '';
        }


        return [
            'type' => $start ? 'time' : 'date',
            'date' => $date,
            'content' => $content
        ];
    }




    // Metoda pro přidání nové možnosti do pole typu čas
    public function addNewTimeOption($date, $lastEnd = null) : array
    {
        if($lastEnd){
            return [
                'type' => 'time',
                'date' => $date,
                'start' => $lastEnd,
                'end' => $this->getEndOfTimeOption($lastEnd, 60),
            ];
        }
        else {
            return [
                'type' => 'time',
                'date' => $date,
                'start' => Carbon::now()->format('H:i'),
                'end' => Carbon::now()->addHour()->format('H:i'),
            ];
        }
    }



    private function checkDupliciteTimeOptions($dates): ?string
    {

        foreach ($dates as $date) {
            $optionContent = [];

            // Načtení všech možností v textové podobě podobě
            foreach ($date['options'] as $option) {
                $optionContent[] = $this->convertTimeOptionToText($option);
            }

            // Porovnání všech termínů a unikátních termínů
            if (count($optionContent) !== count(array_unique($optionContent))) {
                return 'Duplicate time options are not allowed.';
            }
        }
        return null;
    }


    // Metoda pro převod konce časové možnosti
    private function getEndOfTimeOption($start, $minutes){
        return Carbon::parse($start)->addMinutes($minutes)->format('H:i');
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


    // Tohle přesunout do služby
    // Metoda pro načtení časových možností
    public function getPollTimeOptions(?Poll $poll = null) : array
    {
        if(!$poll){
            return [];
        }

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

        return $dates;
        //dd($this->dates);

    }




}
