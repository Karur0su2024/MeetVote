<?php

namespace App\Services;

use App\Models\Poll;
use Carbon\Carbon;
use App\Models\TimeOption;

class TimeOptionService
{
    public function getPollTimeOptions(?Poll $poll) : array
    {
        $timeOptions = [];

        if(!$poll){
            $timeOptions[] = $this->addNewOption(Carbon::today()->format('Y-m-d'), 'time', null);

            $timeOptions[] = $this->addNewOption(Carbon::tomorrow()->format('Y-m-d'), 'time', null);

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

    public function deleteTimeOptions(array $deletedOptions) : void
    {
        TimeOption::whereIn('id', $deletedOptions)->delete();
    }

    public function saveTimeOptions(Poll $poll, array $timeOptions) : bool
    {
        foreach($timeOptions as $option) {
            if ($option['type'] == 'time') {
                $minutes = Carbon::parse($option['content']['start'])->diffInMinutes($option['content']['end']);

                if (isset($option['id'])) {



                    // Aktualizace časové možnosti, která již existuje
                    $newOption = TimeOption::find($option['id']);
                    if (!$newOption) {

                        return false;
                    }
                    $newOption->update([
                        'start' => $option['date'] . ' ' . $option['content']['start'],
                        'minutes' => $minutes
                    ]);



                } else {

                    // Přidání nové časové možnosti do databáze
                    $poll->timeOptions()->create([
                        'date' => $option['date'],
                        'start' => $option['content']['start'],
                        'minutes' => $minutes
                    ]);
                }
            } else {

                if (isset($option['id'])) {
                    // Aktualizace textové možnosti, která již existuje
                    $newOption = TimeOption::find($option['id']);
                    if (!$newOption) {
                        $this->addError('save', 'Failed to update: Time option not found.');
                        return false;
                    }
                    $newOption->update([
                        'text' => $option['content']['text'],
                    ]);

                } else {

                    // Přidání textové možnosti do databáze
                    $poll->timeOptions()->create([
                        'date' => $option['date'],
                        'text' => $option['content']['text'],
                    ]);

                }
            }
        }
        return true;
    }


    // Metoda pro vytvoření nové časové možnosti do pole
    public function addNewOption($date, $type, $lastEnd) : array
    {
        //return $this->addNewTimeOption($date, $lastEnd);
        //dd($lastEnd);


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
    public function addNewTimeOption($lastEnd) : array
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



    public function checkDuplicity($options): bool
    {
        $toCheck = array_map(function ($item) {
            return $this->convertContentToText($item);
        }, $options);

        //dd($toCheck);


        return count($options) !== count(array_unique($toCheck));

    }


    // Metoda pro převod konce časové možnosti
    private function getEndOfTimeOption($start, $minutes){
        return Carbon::parse($start)->addMinutes($minutes)->format('H:i');
    }


    // Metoda pro konverzi časové možnosti na textovou podobu
    private function convertContentToText($option) : string
    {
        return $option['date'] . ' ' . strtolower(implode('-', $option['content']));

    }





}
