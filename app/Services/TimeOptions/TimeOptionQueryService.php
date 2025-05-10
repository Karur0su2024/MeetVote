<?php

namespace App\Services\TimeOptions;

use App\Models\Poll;
use App\Models\TimeOption;
use Carbon\Carbon;
use App\Models\Vote;

class TimeOptionQueryService
{

    // Načtení časových možností pro anketu
    public function getTimeOptionsArray(Poll $poll): array
    {

        // Pokud není anketa nastavena, vrátí jednu časovou možnost.
        if ($poll->id === null) {
            return $this->initialTimeOption();
        }

        $allowInvalid = $poll->settings['allow_invalid'] ?? false;

        $timeOptions = [];
        foreach ($poll->timeOptions as $timeOption) {

            // Kontrola typu časové možnosti
            $content = $timeOption->start ? [
                // Typ čas
                'start' => Carbon::parse($timeOption->start)->format('H:i'),
                'end' => Carbon::parse($timeOption->end)->format('H:i'),
            ] : [
                'text' => $timeOption->text, // Typ text
            ];

            $time = $timeOption->start ?? '23:59:59';
            $datetime = $timeOption->date . ' ' . $time;


            $timeOptions[$timeOption->id] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'date_formatted' => Carbon::parse($timeOption->date)->format('l, F d, Y'),
                'type' => $timeOption->start ? 'time' : 'text',
                'content' => $content,
                'datetime' => $datetime,
                'invalid' => $allowInvalid ? false : (now() >= $datetime), // Nastavení platnosti časové možnosti
                'full_content' => implode(' - ', $content),
                'score' => $this->getOptionScore($timeOption),
                'picked_preference' => 0, // Výchozí hodnota preference (nevybráno)
            ];
        }


        return $timeOptions;

    }





    // Metoda pro získání bodového ohodnocení časové možnosti
    private function getOptionScore(TimeOption $option): int
    {
        $score = 0;
        foreach ($option->votes as $vote) {
            $score += $vote->preference;
        }
        return $score;
    }

    // Nastavení výchozí časové možnosti
    private function initialTimeOption(): array
    {
        return [[
            'type' => 'time',
            'date' => Carbon::today()->format('Y-m-d'),
            'score' => 0,
            'invalid' => false,
            'content' => [
                'start' => '',
                'end' => '',
            ],
        ]];
    }


    // Nastavení preferencí pro časové možnosti podle dat odpovědí
    public function getVotingArray(Poll $poll, $vote = null): array
    {
        $options = $this->getTimeOptionsArray($poll); // Získání časových možností

        foreach ($vote->timeOptions ?? [] as $timeOption) {
            $options[$timeOption->time_option_id]['picked_preference'] = $timeOption->preference;
        }

        return $options;
    }

}
