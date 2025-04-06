<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Poll;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionQueryService;

class PollResultsService
{

    public function __construct(
        protected TimeOptionQueryService $timeOptionQueryService,
        protected QuestionQueryService $questionQueryService,
    ) {}

    public function getResults($poll): array
    {

        $timeOptions = $this->timeOptionQueryService->getTimeOptionsArray($poll);

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

}
