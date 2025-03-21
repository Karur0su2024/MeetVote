<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\VoteQuestionOption;
use App\Models\VoteTimeOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\VoteException;

/**
 *
 */
class VoteService
{
    /**
     * @var TimeOptionService
     */
    protected TimeOptionService $timeOptionService;
    /**
     * @var QuestionService
     */
    protected QuestionService $questionService;

    /**
     * Konstruktor pro inicializaci služeb
     * @param TimeOptionService $timeOptionService
     * @param QuestionService $questionService
     */
    public function __construct(TimeOptionService $timeOptionService, QuestionService $questionService)
    {
        $this->timeOptionService = $timeOptionService;
        $this->questionService = $questionService;
    }

    /**
     * Metoda pro získaní dat pro hlasování.
     * @param Poll $poll Anketa, pro kterou se získávají data.
     * @param $voteId / V případě nenullové hodnoty, se načte existující hlas i se zvolenými preferencemi.
     * @return array Pole s daty o hlasu.
     */
    public function getPollData(int $pollId, $voteId = null): array
    {

        $poll = Poll::find($pollId);
        return [
            'user' => [
                'name' => Auth::user()->name ?? '',
                'email' => Auth::user()->email ?? '',
            ],
            'time_options' => $this->transformTimeOptionData($this->timeOptionService->getPollTimeOptions($poll), $voteId), // Pole časových možností
            'questions' => $this->transformQuestionData($this->questionService->getPollQuestions($poll), $voteId), // Pole otázek
            'vote_index' => $voteId, // Id existujícího hlasu pro případnou její změnu
        ];
    }


    /**
     * Metoda pro získání výsledků hlasování.
     * @param Poll $poll Anketa, pro kterou se získávají výsledky
     * @return array Pole s výsledky hlasování
     */
    public function getPollResults(Poll $poll)
    {
        $votes = $poll->votes;

        $pollResults = [];

        foreach ($votes as $voteIndex => $vote) {
            $pollResults[$voteIndex]['id'] = $vote->id;
            $pollResults[$voteIndex]['user_id'] = $vote->user_id;
            $pollResults[$voteIndex]['voter_name'] = $vote->voter_name;
            $pollResults[$voteIndex]['updated_at'] = $vote->updated_at;
            $pollResults[$voteIndex]['time_options'] = $this->transformTimeOptionData($this->timeOptionService->getPollTimeOptions($poll), $vote->id);
            $pollResults[$voteIndex]['questions'] = $this->transformQuestionData($this->questionService->getPollQuestions($poll), $vote->id);
        }

        return $pollResults;
    }

    /**
     * Metoda pro získání dat o časových možnostech pro hlasování.
     * Vratí pole s daty s časovými možnostmi.
     * @param array $options
     * @param $voteIndex
     * @return array
     */
    private function transformTimeOptionData(array $options, $voteIndex = null): array
    {
        $timeOptions = [];

        foreach ($options as $option) {
            $content = $option['content']['text'] ?? '('.$option['content']['start'].' - '.$option['content']['end'].')'; // Obsah časové možnosti, pro lepší zpracování

            $preference = 0; // Výchozí preference
            if ($voteIndex) $preference = $this->getTimeOptionPreference($voteIndex, $option['id']); //Pokud je hlasování již uloženo, získá preference pro danou možnost

            $timeOptions[] = [
                'id' => $option['id'],
                'date' => $option['date'],
                'date_formatted' => $option['date_formatted'],
                'content' => $content,
                'score' => $option['score'],
                'picked_preference' => $preference ?? 0,
            ];
        }

        return $timeOptions;
    }


    /**
     * Metoda pro získání dat o otázkách pro hlasování
     * Vratí pole s daty s otázkami
     * @param $data
     * @param $voteIndex
     * @return array
     */
    private function transformQuestionData($data, $voteIndex = null): array
    {
        $questions = [];

        foreach ($data as $question) {
            $options = [];
            foreach ($question['options'] as $option) {
                $preference = 0; // Výchozí preference
                if ($voteIndex) $preference = $this->getQuestionOptionPreference($voteIndex, $option['id']);

                $options[] = [
                    'id' => $option['id'],
                    'text' => $option['text'],
                    'score' => $option['score'],
                    'picked_preference' => $preference ?? 0,
                ];
            }

            $questions[] = [
                'id' => $question['id'],
                'text' => $question['text'],
                'options' => $options,
            ];
        }

        return $questions;
    }



    /**
     * Metoda pro uložení hlasu do databáze.
     * V případě, že je hlas již uložen, aktualizuje se.
     * V případě, že je hlas nový, vytvoří se nový záznam.
     * @param $validatedVoteData
     * @return Vote|null
     * @throws \Throwable
     */
    public function saveVote($validatedVoteData): ?Vote
    {
        try {
            DB::beginTransaction();

            if (!isset($validatedVoteData['existingVote'])) {

                $vote = Vote::create([
                    'poll_id' => $validatedVoteData['poll_id'],
                    'voter_name' => $validatedVoteData['user']['name'],
                    'voter_email' => $validatedVoteData['user']['email'],
                ]);

            } else {

                $vote = Vote::find($validatedVoteData['existingVote']);
                if (!$vote) {
                    throw new VoteException('Vote not found');
                }
                $vote->update(
                    [
                        'voter_name' => $validatedVoteData['user']['name'],
                        'voter_email' => $validatedVoteData['user']['email'],
                    ]
                );
            }

            $this->saveTimeOptionsVotes($vote, $validatedVoteData);

            $this->saveQuestionOptionsVotes($vote, $validatedVoteData);

            DB::commit();

            return $vote;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new VoteException('Error saving vote: ' . $e->getMessage());
        }

    }

    /**
     * Metoda pro uložení hlasů pro časové možnosti
     * @param $vote
     * @param $data
     * @return void
     */
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

    /**
     * Metoda pro kontrolu, zda je alespoň jedna preference vybrána.
     * @param $data
     * @return bool
     */
    public function atLeastOnePickedPreference($data): bool
    {
        $timeOptions = $data['timeOptions'] ?? [];
        $questions = $data['questions'] ?? [];

        foreach ($timeOptions as $option) {
            if ($option['picked_preference'] !== 0) {
                return true;
            }
        }

        foreach ($questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['picked_preference'] !== 0) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Metoda pro získání preference pro časovou možnost
     * @param $voteIndex
     * @param $optionId
     * @return int Hodnota preference
     */
    private function getTimeOptionPreference($voteIndex, $optionId)
    {
        $preferenceOption = VoteTimeOption::where('vote_id', $voteIndex)
            ->where('time_option_id', $optionId)
            ->first();

        return $preferenceOption ? $preferenceOption->preference : 0;
    }

    /**
     * Metoda pro získání preference pro možnost otázky
     * @param $voteIndex
     * @param $optionId
     * @return int
     */
    private function getQuestionOptionPreference($voteIndex, $optionId)
    {
        $preferenceOption = VoteQuestionOption::where('vote_id', $voteIndex)
            ->where('question_option_id', $optionId)
            ->first();

        return $preferenceOption ? $preferenceOption->preference : 0;
    }

}
