<?php

namespace App\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    public function saveVote($poll, $userName, $userEmail, $timeOptions, $questions, $existingVote = null)
    {
        if ($existingVote) {
            // Aktualizace existujícího hlasu
            $vote = $existingVote;
            $vote->voteTimeOptions()->delete(); // Smazání předchozích dat
        } else {
            // Vytvoření nového hlasu
            $vote = Vote::create([
                'poll_id' => $poll->id,
                'user_id' => Auth::id(),
                'voter_name' => $userName,
                'voter_email' => $userEmail,
            ]);
        }

        $this->saveOptionsToDatabase($vote, $timeOptions, $questions);

        return $vote;
    }

    // Metoda pro uložení jednotlivých odpovědí do databáze
    private function saveOptionsToDatabase($vote, $timeOptions, $questions)
    {
        foreach ($timeOptions as $timeOption) {
            if ($timeOption['chosen_preference'] != 0) {
                $vote->voteTimeOptions()->create([
                    'time_option_id' => $timeOption['id'],
                    'preference' => $timeOption['chosen_preference'],
                ]);
            }
        }

        foreach ($questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['chosen_preference'] != 0) {
                    $vote->voteQuestionOptions()->create([
                        'poll_question_id' => $question['id'],
                        'question_option_id' => $option['id'],
                        'preference' => $option['chosen_preference'],
                    ]);
                }
            }
        }
    }
}
