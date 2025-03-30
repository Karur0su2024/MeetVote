<?php

namespace App\Services\Vote;

use App\Livewire\Forms\VotingForm;
use App\Models\Poll;

class VoteValidationService
{

    public function isPickedPreferenceValid($validatedData): bool
    {
        foreach ($validatedData['timeOptions'] ?? [] as $timeOption) {
            if ($timeOption['picked_preference'] !== -0) {
                return false;
            }
        }

        foreach ($validatedData['questions'] ?? [] as $question) {
            foreach ($question['options'] as $option) {
                if ($option['picked_preference'] !== 0) {
                    return false;
                }
            }
        }

        return true;
    }

}
