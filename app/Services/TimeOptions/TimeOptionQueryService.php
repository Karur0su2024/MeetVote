<?php

namespace App\Services\TimeOptions;

use App\Models\Poll;
use App\Models\TimeOption;
use Carbon\Carbon;
use App\Models\Vote;

class TimeOptionQueryService
{

    /**
     * Metoda pro načtení časových možností ankety.
     * Pokud není anketa nastavena, vrátí jednu časovou možnost.
     * Pokud je anketa nastavena, vrátí pole časových možností ankety.
     * Je vhodné použít eager loading pro načtení časových možností.
     * @param Poll|null $poll
     * @return array
     */
    public function getTimeOptionsArray(Poll $poll): array
    {

        // Pokud není anketa nastavena, vrátí jednu časovou možnost.
        if ($poll->id === null) {
            return $this->initialTimeOption();
        }

        $timeOptions = [];
        foreach ($poll->timeOptions as $timeOption) {

            $content = $timeOption->start ? [
                'start' => Carbon::parse($timeOption->start)->format('H:i'),
                'end' => Carbon::parse($timeOption->end)->format('H:i'),
            ] : [
                'text' => $timeOption->text,
            ];

            $timeOptions[$timeOption->id] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'date_formatted' => Carbon::parse($timeOption->date)->format('l, F d, Y'),
                'type' => $timeOption->start ? 'time' : 'text',
                'content' => $content,
                'full_content' => implode(' - ', $content),
                'score' => $this->getOptionScore($timeOption),
                'picked_preference' => 0,
            ];
        }

        if(count($timeOptions) === 0) {
            return $this->initialTimeOption();
        }

        return $timeOptions;

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



    /**
     * Metoda pro získání dat o časových možnostech pro hlasování.
     * Vratí pole s daty s časovými možnostmi.
     * @param array $options
     * @param $voteIndex
     * @return array
     */
    public function getVotingArray(Poll $poll, $vote = null): array
    {
        $options = $this->getTimeOptionsArray($poll); // Získání časových možností

        foreach ($vote->timeOptions ?? [] as $timeOption) {
            $options[$timeOption->time_option_id]['picked_preference'] = $timeOption->preference;
        }

        return $options;
    }

}
