<?php

namespace App\Services\Vote;

use App\Events\VoteSubmitted;
use App\Exceptions\VoteException;
use App\Models\Vote;
use App\Models\VoteQuestionOption;
use App\Models\VoteTimeOption;
use Illuminate\Support\Facades\DB;

class VoteCreateService
{
    public function __construct()
    {
    }


    public function saveVote($validatedVoteData)
    {
        try {
            DB::beginTransaction();
            $vote = Vote::updateOrCreate(
                [
                    'id' => $validatedVoteData['existingVote'],
                ],
                $this->buildVote($validatedVoteData)
            );

            $this->saveTimeOptionsVotes($vote, $validatedVoteData);
            $this->saveQuestionOptionsVotes($vote, $validatedVoteData);

            DB::commit();
            $message = $vote->wasRecentlyCreated ? 'Vote successfully saved.' : 'Vote successfully updated.';
            VoteSubmitted::dispatchIf($vote->wasRecentlyCreated, $vote);
            
            redirect(request()->header('Referer'))->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
        }

    }


    private function saveTimeOptionsVotes($vote, $data)
    {
        $vote->timeOptions()->delete(); // Smazání předchozích hlasů pro časové možnosti, protože nejsou potřeba

        if (isset($data['timeOptions'])) {
            $vote->timeOptions()->saveMany($this->buildTimeOptionsVotes($data['timeOptions']));
        }
    }

    private function buildTimeOptionsVotes($options): array
    {
        $timeOptionsVotes = [];
        foreach ($options as $option) {
            if ($option['picked_preference'] === 0 || $option['invalid']) continue;

            $timeOptionsVotes[] = New VoteTimeOption([
                'time_option_id' => $option['id'],
                'preference' => $option['picked_preference'],
            ]);
        }

        return $timeOptionsVotes;
    }

    private function saveQuestionOptionsVotes($vote, $data)
    {
        $vote->questionOptions()->delete(); // Smazání předchozích hlasů pro otázky, protože nejsou potřeba

        if (isset($data['questions'])) {
            $vote->questionOptions()->saveMany($this->buildQuestionOptionsVotes($data['questions']));
        }
    }

    private function buildQuestionOptionsVotes($questions): array
    {
        $questionOptions = [];
        foreach ($questions as $question) {
            foreach ($question['options'] as $option) {

                if ($option['picked_preference'] === 0) continue; // Pokud není preference vybrána, je tato možnost přeskočena

                $questionOptions[] = New VoteQuestionOption([
                    'poll_question_id' => $question['id'],
                    'question_option_id' => $option['id'],
                    'preference' => $option['picked_preference'],
                ]);
            }
        }

        return $questionOptions;
    }


    private function buildVote($validatedVoteData): array
    {
        return [
            'poll_id' => $validatedVoteData['pollIndex'],
            'voter_name' => $validatedVoteData['user']['name'],
            'voter_email' => $validatedVoteData['user']['email'],
            'message' => $validatedVoteData['notes'] ?? null,
        ];
    }

}
