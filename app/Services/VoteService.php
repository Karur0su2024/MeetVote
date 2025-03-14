<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\VoteQuestionOption;
use App\Models\VoteTimeOption;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    protected TimeOptionService $timeOptionService;

    protected QuestionService $questionService;

    // Konstruktor pro inicializaci služeb
    public function __construct()
    {
        $this->timeOptionService = app(TimeOptionService::class);
        $this->questionService = app(QuestionService::class);
    }

    // Metoda pro získání dat o hlasování
    // Vratí data o hlasování pro daný dotazník
    // Vratí pole s daty o uživateli, časových možnostech a otázkách
    public function getPollData(Poll $poll, $voteId = null): array
    {


        $data = [
            'user' => [
                'name' => Auth::user()->name ?? '',
                'email' => Auth::user()->email ?? '',
            ],
            'time_options' => $this->getTimeOptionsData($this->timeOptionService->getPollTimeOptions($poll), $voteId),
            'questions' => $this->getQuestionData($this->questionService->getPollQuestions($poll), $voteId),
            'vote_index' => $voteId,
        ];

        return $data;
    }

    // Metoda pro získání dat o časových možnostech pro hlasování
    // Vratí pole s daty o časových možnostech
    private function getTimeOptionsData($data, $voteIndex = null): array
    {
        $timeOptions = [];

        foreach ($data as $option) {
            $preference = 0;
            $content = $option['content']['text'] ?? '('.$option['content']['start'].' - '.$option['content']['end'].')';
            if ($voteIndex) {

                $preferenceOption = VoteTimeOption::where('vote_id', $voteIndex)
                    ->where('time_option_id', $option['id'])
                    ->first();

                if ($preferenceOption !== null) {
                    $preference = $preferenceOption->preference;

                }

            }

            $timeOptions[] = [
                'id' => $option['id'],
                'date' => $option['date'],
                'content' => $content,
                'score' => $option['score'],
                'picked_preference' => $preference ?? 0,
            ];
        }

        return $timeOptions;
    }

    // Metoda pro získání dat o otázkách pro hlasování
    // Vratí pole s daty s otázkami
    private function getQuestionData($data, $voteIndex = null): array
    {
        $questions = [];

        foreach ($data as $question) {
            $options = [];
            foreach ($question['options'] as $option) {
                if ($voteIndex) {
                    $preferenceOption = VoteQuestionOption::where('vote_id', $voteIndex)
                        ->where('question_option_id', $option['id'])
                        ->first();
                    if ($preferenceOption) {
                        $preference = $preferenceOption->preference;
                    }
                }

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



    // -------------------------------------------------
    // Metody pro uložení
    //
    //
    //
    // Metoda pro uložení hlasu do databáze
    // V případě, že je hlas již uložen, aktualizuje se
    // V případě, že je hlas nový, vytvoří se nový záznam
    public function saveVote($data): Vote
    {
        if (! isset($data['existingVote'])) {
            $vote = Vote::create(
                [
                    'poll_id' => $data['poll_id'],
                    'user_id' => Auth::user()->id ?? null,
                    'voter_name' => $data['user']['name'],
                    'voter_email' => $data['user']['email'],
                ]
            );
        } else {
            $vote = Vote::find($data['existingVote']);
            if (! $vote) {
                throw new \Exception('Vote not found');
            }
            $vote->update(
                [
                    'voter_name' => $data['user']['name'],
                    'voter_email' => $data['user']['email'],
                ]
            );
        }

        $this->saveTimeOptionsVotes($vote, $data);

        $this->saveQuestionOptionsVotes($vote, $data);

        return $vote;
    }

    // Metoda pro uložení hlasů pro časové možnosti
    private function saveTimeOptionsVotes($vote, $data)
    {

        $vote->timeOptions()->delete();

        if (isset($data['timeOptions'])) {

            foreach ($data['timeOptions'] as $option) {

                if ($option['picked_preference'] == 0) {
                    continue;
                }

                VoteTimeOption::Create(
                    [
                        'vote_id' => $vote->id,
                        'time_option_id' => $option['id'],
                        'preference' => $option['picked_preference'],
                    ]
                );
            }
        }
    }

    // Metoda pro uložení hlasů pro otázky
    private function saveQuestionOptionsVotes($vote, $data)
    {
        $vote->questionOptions()->delete();

        if (isset($data['questions'])) {

            foreach ($data['questions'] as $question) {
                foreach ($question['options'] as $option) {
                    if ($option['picked_preference'] == 0) {
                        continue;
                    }

                    VoteQuestionOption::create([
                        'vote_id' => $vote->id,
                        'poll_question_id' => $question['id'],
                        'question_option_id' => $option['id'],
                        'preference' => $option['picked_preference'],
                    ]);
                }
            }
        }
    }


    // Metoda pro kontrolu, zda je alespoň jedna preference vybrána
    public function atLeastOnePickedPreference($data)
    {
        $timeOptions = $data['timeOptions'] ?? [];
        $questions = $data['questions'] ?? [];

        foreach ($timeOptions as $option) {
            if ($option['picked_preference'] != 0) {
                return true;
            }
        }

        foreach ($questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['picked_preference'] != 0) {
                    return true;
                }
            }
        }

        return false;
    }


    public function getPollResults(Poll $poll)
    {
        $votes = $poll->votes;

        $data = [];

        foreach ($votes as $voteIndex => $vote) {
            $data[$voteIndex]['id'] = $vote->id;
            $data[$voteIndex]['user_id'] = $vote->user_id;
            $data[$voteIndex]['voter_name'] = $vote->voter_name;
            $data[$voteIndex]['updated_at'] = $vote->updated_at;
            $data[$voteIndex]['time_options'] = $this->getTimeOptionsData($this->timeOptionService->getPollTimeOptions($poll), $vote->id);
            $data[$voteIndex]['questions'] = $this->getQuestionData($this->questionService->getPollQuestions($poll), $vote->id);
        }

        return $data;
    }
}
