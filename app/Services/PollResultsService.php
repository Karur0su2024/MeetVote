<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Poll;

class PollResultsService
{



    protected PollService $pollService;

    public function __construct(PollService $pollService){
        $this->pollService = $pollService;
    }

    public function getPollResultsData($poll)
    {


        $timeOptions = $this->pollService->getTimeOptionService()->getPollTimeOptions($poll);

        usort($timeOptions, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });


        foreach ($timeOptions as &$timeOption) {
            $timeOption['content']['full'] = implode(' - ', $timeOption['content']);
        }

        $questions = $this->pollService->getQuestionService()->getPollQuestions($poll);
        $questionArray = [];

        foreach ($questions as $question) {
            $options = $question['options'];

            usort($options, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });



            $questionArray[] = [
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
