<?php

namespace App\Services\Vote;

use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class VoteValidationService
{

    public function validateVote($poll, $validatedData): ?string
    {
        if($this->isPickedPreferenceInvalid($validatedData)){
            return 'You must select at least one option.';
        }

        if($this->guestAlreadyVoted($poll, $validatedData['user']['email'])){
            return 'You already voted under this email.';
        }


        return null;
    }

    public function isPickedPreferenceInvalid($validatedData): bool
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


    public function guestAlreadyVoted($poll, $email): bool
    {
        if(Auth::check()) {
            return false;
        }

        $vote = $poll->votes()
            ->where('voter_email', $email)->first();

        if($vote) {
            return true;
        }

        return false;
    }

}
