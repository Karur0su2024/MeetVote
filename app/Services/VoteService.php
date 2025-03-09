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

    public function __construct()
    {
        $this->timeOptionService = app(TimeOptionService::class);
        $this->questionService = app(QuestionService::class);
    }

    // Metoda pro uložení hlasu do databáze
    public function saveVote($data)
    {

        $vote = Vote::updateOrCreate(
            [
                'poll_id' => $data['poll_id'],
                'user_id' => Auth::user()->id,
                'id' => $data['existingVote'],
            ],
            [
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
            ]
        );

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

    public function getPollData(Poll $poll, $voteId = null): array
    {
        $data = [
            'user' => [
                'name' => Auth::user()->name ?? '',
                'email' => Auth::user()->email ?? '',
            ],
            'time_options' => $this->getTimeOptionsData($this->timeOptionService->getPollTimeOptions($poll)),
            'questions' => $this->getQuestionData($this->questionService->getPollQuestions($poll)),
        ];

        return $data;
    }

    private function getTimeOptionsData($data, $voteIndex = null): array
    {
        $timeOptions = [];

        foreach ($data as $option) {
            // dd($option);
            $content = $option['content']['text'] ?? '(' . $option['content']['start'] . ' - ' . $option['content']['start'] . ')';
            if ($voteIndex) {
                $preference = VoteTimeOption::where('vote_id', $voteIndex)
                    ->where('time_option_id', $option['id'])
                    ->first()->preference;
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

    private function getQuestionData($data, $voteIndex = null): array
    {
        $questions = [];

        foreach ($data as $question) {
            $options = [];
            foreach ($question['options'] as $option) {
                if ($voteIndex) {
                    $preference = Vote::where('vote_id', $voteIndex)
                        ->where('question_id', $question['id'])
                        ->where('option_id', $option['id'])
                        ->first()->preference;
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
