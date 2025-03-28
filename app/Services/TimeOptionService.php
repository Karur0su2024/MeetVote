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
     * Je vhodné použít eager loading pro načtení časových možností.
     * @param Poll|null $poll
     * @return array
     */
    public function getPollTimeOptions(Poll $poll): array
    {

        // Pokud není anketa nastavena, vrátí jednu časovou možnost.
        if ($poll->id === null) {
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
    public function saveTimeOptions(Poll $poll, array $timeOptions, array $removedTimeOptions): bool
    {
        $this->deleteTimeOptions($removedTimeOptions);


        foreach ($timeOptions as $option) {

            $optionToAdd = $this->builtTimeOption($option);



            if (isset($option['id'])) {
                TimeOption::where('id', $option['id'])->update($optionToAdd);
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
        if(count($deletedOptions) === 0) {
            return;
        }
        TimeOption::whereIn('id', $deletedOptions)->delete();
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


    private function builtTimeOption(array $validatedData): array
    {
        return [
            'date' => $validatedData['date'],
            'text' => $validatedData['content']['text'] ?? null,
            'start' => $validatedData['content']['start'] ?? null,
            'end' => $validatedData['content']['end'] ?? null,
        ];
    }
}
