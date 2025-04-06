<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionQueryService;
use Illuminate\Support\Facades\Auth;
use App\Models\VoteTimeOption;

class PollResultsService
{

    public function __construct(
        protected TimeOptionQueryService $timeOptionQueryService,
        protected QuestionQueryService $questionQueryService,
    ) {}

    public function getResults($poll): array
    {
        $preferences = $this->getPreferenceData($poll);

        $timeOptions = $this->timeOptionQueryService->getTimeOptionsArray($poll);

        $timeOptions = $this->addPreferencesToTimeOptions($timeOptions, $preferences['timeOptions']);


        usort($timeOptions, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $questions = $this->questionQueryService->getQuestionsArray($poll);

        $questionArray = [];

        foreach ($questions as $question) {
            $options = $question['options'];

            usort($options, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });


            $questionArray[] = [
                'id' => $question['id'],
                'text' => $question['text'],
                'options' => $options,
                'selected' => 0,
            ];
        }

        return [
            'timeOptions' => [
                'options' => $timeOptions,
                'selected' => 0,
            ],
            'questions' => $questionArray,
        ];

    }


    public function getUserVote($poll): ?Vote
    {
        $vote = null;
        if (Auth::check()) {
            $vote = Vote::with(['timeOptions.timeOption', 'questionOptions.questionOption.pollQuestion'])
                ->where('poll_id', $poll->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return $vote;

    }


    public function getPreferenceData($poll) {
        $votes = $poll->votes;

        $preferences = [
            'timeOptions' => [],
            'questions' => [],
        ];

        foreach ($votes as $vote) {

            foreach ($vote->timeOptions as $timeOption) {
                $preferences['timeOptions'][$timeOption->time_option_id][$timeOption->preference][] = $vote->voter_name;
            }

            foreach ($vote->questionOptions as $questionOption) {
                $preferences['questions'][$questionOption->poll_question_id][$questionOption->question_option_id][$questionOption->preference][] =
                    $vote->voter_name;
            }
        }

        return $preferences;

    }


    private function addPreferencesToTimeOptions($timeOptions, $preferences): array
    {
        foreach ($timeOptions as $key => $timeOption) {
            $timeOptions[$key]['preferences'] = [
                2 => $preferences[$timeOption['id']][2] ?? [],
                1 => $preferences[$timeOption['id']][1] ?? [],
                -1 => $preferences[$timeOption['id']][-1] ?? [],
            ];
        }

        return $timeOptions;
    }

}
