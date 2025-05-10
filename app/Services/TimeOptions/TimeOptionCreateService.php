<?php

namespace App\Services\TimeOptions;

use App\Models\Poll;
use App\Models\TimeOption;

class TimeOptionCreateService
{

    // Uložení časdových možností pro anketu
    public function save(Poll $poll, array $timeOptions, array $removedTimeOptions): bool
    {
        $this->deleteTimeOptions($removedTimeOptions);

        foreach ($timeOptions as $option) {

            $optionToAdd = $this->builtTimeOption($option);

            if (isset($option['id'])) {
                // Pokud už někdo pro časovou možnost hlasoval, tak je přeskočena
                if($option['score'] !== 0) {
                    continue;
                }

                TimeOption::where('id', $option['id'])->update($optionToAdd);
            } else {
                $poll->timeOptions()->create($optionToAdd);
            }
        }

        return true;
    }


    // Odstranění časových možností
    private function deleteTimeOptions(array $deletedOptions): void
    {
        if(count($deletedOptions) === 0) {
            return;
        }
        TimeOption::whereIn('id', $deletedOptions)->delete();
    }



    // Sestavení časové možnosti
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
