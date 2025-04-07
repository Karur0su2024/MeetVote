<?php

namespace App\Services\Vote;

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


    /**
     * Metoda pro uložení hlasu do databáze.
     * V případě, že je hlas již uložen, aktualizuje se.
     * V případě, že je hlas nový, vytvoří se nový záznam.
     * @param $validatedVoteData
     * @return Vote|null
     * @throws \Throwable
     */
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

            if($validatedVoteData['existingVote']){
                $message = 'Vote successfully updated.';
            }
            else {
                $message = 'Vote successfully saved.';
            }

            redirect(request()->header('Referer'))->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            throw new VoteException('Error saving vote: ' . $e->getMessage());
        }

    }


    private function saveTimeOptionsVotes($vote, $data)
    {
        $vote->timeOptions()->delete(); // Smazání předchozích hlasů pro časové možnosti, protože nejsou potřeba

        if (isset($data['timeOptions'])) {
            $timeOptionsVotes = [];
            foreach ($data['timeOptions'] as $option) {
                if ($option['picked_preference'] == 0) continue;

                $timeOptionsVotes[] = New VoteTimeOption([
                    'vote_id' => $vote->id,
                    'time_option_id' => $option['id'],
                    'preference' => $option['picked_preference'],
                ]);
            }
            $vote->timeOptions()->saveMany($timeOptionsVotes);
        }
    }


    /**
     * Metoda pro uložení hlasů pro otázky.
     * @param $vote
     * @param $data
     * @return void
     */
    private function saveQuestionOptionsVotes($vote, $data)
    {
        $vote->questionOptions()->delete(); // Smazání předchozích hlasů pro otázky, protože nejsou potřeba

        if (isset($data['questions'])) {
            $questionOptions = [];
            foreach ($data['questions'] as $question) {
                foreach ($question['options'] as $option) {

                    if ($option['picked_preference'] === 0) continue; // Pokud není preference vybrána, je tato možnost přeskočena

                    $questionOptions[] = New VoteQuestionOption([
                        'vote_id' => $vote->id,
                        'poll_question_id' => $question['id'],
                        'question_option_id' => $option['id'],
                        'preference' => $option['picked_preference'],
                    ]);
                }
            }

            $vote->questionOptions()->saveMany($questionOptions); // Uložení hlasů pro otázky
        }
    }


    private function buildVote($validatedVoteData): array
    {
        return [
            'poll_id' => $validatedVoteData['poll_id'],
            'voter_name' => $validatedVoteData['user']['name'],
            'voter_email' => $validatedVoteData['user']['email'],
        ];
    }

}
