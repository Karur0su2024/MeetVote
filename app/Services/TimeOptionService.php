<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\TimeOption;
use Carbon\Carbon;

class TimeOptionService
{
    /**
     * Metoda pro načtení časových možností ankety.
     * Pokud není anketa nastavena, vrátí jednu časovou možnost.
     * Pokud je anketa nastavena, vrátí pole časových možností ankety.
     * @param Poll|null $poll
     * @return array
     */
    public function getPollTimeOptions(Poll $poll): array
    {

        // Pokud není anketa nastavena, vrátí jednu časovou možnost.
        if (!isset($poll->id)) {
            return $this->initialTimeOption();
        }

        $timeOptions = [];
        foreach ($poll->timeOptions as $timeOption) {
            $timeOptions[] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'date_formatted' => Carbon::parse($timeOption->date)->format('l, F d, Y'),
                'type' => $timeOption->start ? 'time' : 'text',
                'content' => $timeOption->start ? [
                    'start' => Carbon::parse($timeOption->start)->format('H:i'),
                    'end' => Carbon::parse($timeOption->end)->format('H:i'),
                ] : [
                    'text' => $timeOption->text,
                ],
                'score' => $this->getOptionScore($timeOption),
            ];
        }

        if(count($timeOptions) === 0) {
            return $this->initialTimeOption();
        }

        return $timeOptions;

    }

    /**
     * Metoda pro uložení a aktualizaci časových možností.
     * @param Poll $poll
     * @param array $timeOptions
     * @return bool
     */
    public function saveTimeOptions(Poll $poll, array $timeOptions): bool
    {
        foreach ($timeOptions as $option) {

            $optionToAdd = [
                'date' => $option['date'],
                'text' => $option['content']['text'] ?? null,
                'start' => $option['content']['start'] ?? null,
                'end' => $option['content']['end'] ?? null,
            ];

            if (isset($option['id'])) {
                $poll->timeOptions()->where('id', $option['id'])->update($optionToAdd);
            } else {
                $poll->timeOptions()->create($optionToAdd);
            }

        }

        return true;
    }





    /**
     * @param array $deletedOptions
     * @return void
     */
    public function deleteTimeOptions(array $deletedOptions): void
    {
        TimeOption::whereIn('id', $deletedOptions)->delete();
    }



    /**
     * Metoda pro kontrolu duplicity časových možností.
     *
     * Kontroluje se i na server-side, tato metoda však bude v budoucnu pravděpodobně přesunuta jinam.
     * @param array $options
     * @return bool
     */
    public function checkDuplicity(array $options): bool
    {
        $toCheck = array_map(function ($item) {
            return $this->convertContentToText($item);
        }, $options);

        return count($options) !== count(array_unique($toCheck));
    }

    /**
     * Metoda pro kontrolu duplicity časových možností podle data.
     * @param array $dates
     * @return array
     */
    public function checkDuplicityByDates(array $dates): array
    {
        $duplicatesDates = [];

        foreach ($dates as $dateIndex => $date) {
            $optionArray = [];
            foreach($date as $option) {
                $optionArray[] = $this->convertContentToText($option);
            }

            if(count($optionArray) !== count(array_unique($optionArray))) {
                $duplicatesDates[] = $dateIndex;
            }
        }
        return $duplicatesDates;
    }



    /**
     * Metoda pro převod časové možnosti na textovou podobu pro kontrolu duplicity
     * @param $option
     * @return string
     */
    private function convertContentToText($option): string
    {
        return $option['date'].' '.strtolower(implode('-', $option['content']));
    }

    /**
     * Metoda pro získání celkového skóre časové možnosti.
     * @param TimeOption $option
     * @return int
     */
    private function getOptionScore(TimeOption $option): int
    {
        $score = 0;
        foreach ($option->votes as $vote) {
            $score += $vote->preference;
        }
        return $score;
    }

    /**
     * Metoda pro inicializaci časové možnosti.
     * @return array
     */
    private function initialTimeOption(): array
    {
        return [[
            'type' => 'time',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => [
                'start' => Carbon::now()->format('H:i'),
                'end' => Carbon::now()->addMinutes(60)->format('H:i'),
            ],
        ]];
    }

}
