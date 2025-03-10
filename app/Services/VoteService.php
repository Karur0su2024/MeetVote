<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\VoteTimeOption;
use App\Models\VoteQuestionOption;
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

    // Metoda pro uložení hlasu do databáze
    // V případě, že je hlas již uložen, aktualizuje se
    // V případě, že je hlas nový, vytvoří se nový záznam
    public function saveVote($data)
    {
        //dd($data);

        if (!isset($data['existingVote'])) {
            $vote = Vote::create(
                [
                    'poll_id' => $data['poll_id'],
                    'user_id' => Auth::user()->id,
                    'voter_name' => $data['user']['name'],
                    'voter_email' => $data['user']['email'],
                ]
            );
        } else {
            $vote = Vote::find($data['existingVote']);
            if (!$vote) {
                throw new \Exception('Vote not found');
            }
            $vote->update(
                [
                    'voter_name' => $data['user']['name'],
                    'voter_email' => $data['user']['email'],
                ]
            );
        }

        $vote->timeOptions()->delete();

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

        $vote->questionOptions()->delete();

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
        ];

        return $data;
    }

    // Metoda pro získání dat o časových možnostech pro hlasování
    // Vratí pole s daty o časových možnostech
    private function getTimeOptionsData($data, $voteIndex = null): array
    {
        $timeOptions = [];

        foreach ($data as $option) {
            // dd($option);
            $content = $option['content']['text'] ?? '(' . $option['content']['start'] . ' - ' . $option['content']['start'] . ')';
            if ($voteIndex) {

                $preferenceOption = VoteTimeOption::where('vote_id', $voteIndex)
                    ->where('time_option_id', $option['id'])
                    ->first();

                if ($preferenceOption) {
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



    public function sendEmails() {}
}
