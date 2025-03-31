<?php

namespace App\Services\TimeOptions;

use App\Models\Poll;
use App\Models\TimeOption;

class TimeOptionCreateService
{
    /**
     * Metoda pro uložení a aktualizaci časových možností.
     * @param Poll $poll
     * @param array $timeOptions
     * @return bool
     */
    public function save(Poll $poll, array $timeOptions, array $removedTimeOptions): bool
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
    private function deleteTimeOptions(array $deletedOptions): void
    {
        if(count($deletedOptions) === 0) {
            return;
        }
        TimeOption::whereIn('id', $deletedOptions)->delete();
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
