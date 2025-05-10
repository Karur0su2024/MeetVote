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

    // Uložení odpovědi do databáze
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
            $message = $vote->wasRecentlyCreated ? __('pages/poll-show.voting.messages.vote_submitted') : __('pages/poll-show.voting.messages.vote_updated');
            VoteSubmitted::dispatchIf($vote->wasRecentlyCreated, $vote);

            session()->put('poll.' . $validatedVoteData['pollIndex'] . '.vote', $vote->id);
            redirect(request()->header('Referer'))->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
        }

    }


    // Uložení preferencí pro časové možnosti
    private function saveTimeOptionsVotes($vote, $data)
    {
        $vote->timeOptions()->delete(); // Smazání předchozích hlasů pro časové možnosti, protože již nejsou potřeba

        if (isset($data['timeOptions'])) {
            $vote->timeOptions()->saveMany($this->buildTimeOptionsVotes($data['timeOptions']));
        }
    }

    // Sestavení odpovědi pro časové možnosti
    private function buildTimeOptionsVotes($options): array
    {
        $timeOptionsVotes = [];
        foreach ($options as $option) {
            if ($option['picked_preference'] === 0 || $option['invalid']) continue; // Pokud nebyla preference vybrána, je možnost přeskočena

            $timeOptionsVotes[] = New VoteTimeOption([
                'time_option_id' => $option['id'],
                'preference' => $option['picked_preference'],
            ]);
        }

        return $timeOptionsVotes;
    }

    // Uložení preferencí pro otázky
    private function saveQuestionOptionsVotes($vote, $data)
    {
        $vote->questionOptions()->delete(); // Smazání předchozích hlasů pro otázky, protože nejsou potřeba

        if (isset($data['questions'])) {
            $vote->questionOptions()->saveMany($this->buildQuestionOptionsVotes($data['questions']));
        }
    }

    // Sestavení odpovědi pro otázky
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


    // Sestavení odpovědi
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
