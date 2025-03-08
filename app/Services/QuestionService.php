<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\PollQuestion;
use Carbon\Carbon;
use App\Models\QuestionOption;

class QuestionService
{

    public function getPollQuestions(Poll $poll) : array
    {
        $questions = [];

        if(!$poll) {
            return $questions;
        }

        foreach ($poll->questions as $question) {
            $options = [];
            foreach ($question->options as $option) {
                $options[] = [
                    'id' => $option->id,
                    'text' => $option->text,
                ];
            }

            $questions[] = [
                'id' => $question->id,
                'text' => $question->text,
                'options' => $options,
            ];
        }

        return $questions;
    }


    public function saveQuestions(Poll $poll, array $questions) : void
    {
        foreach ($questions as $question) {
            if (isset($question['id'])) {
                $newQuestion = PollQuestion::find($question['id']);

                if(!$newQuestion) {
                    throw new \Exception('Question not found');
                }
                else {
                    $newQuestion->update([
                        'text' => $question['text'],
                    ]);
                }
            }
            else {
                $newQuestion = $poll->questions()->create([
                    'text' => $question['text'],
                ]);
            }


            $this->saveQuestionOptions($newQuestion, $question['options']);
        }
    }




    public function saveQuestionOptions(PollQuestion $question, array $options) : void
    {
        foreach ($options as $option) {
            if (isset($option['id'])) {
                $newOption = QuestionOption::find($option['id']);

                if(!$newOption) {
                    throw new \Exception('Question option not found');
                }
                else {
                    $newOption->update([
                        'text' => $option['text'],
                    ]);
                }
            }
            else {
                $question->options()->create([
                    'text' => $option['text'],
                ]);
            }
        }
    }

    public function deleteQuestions(array $removedQuestions) : void
    {
        PollQuestion::whereIn('id', $removedQuestions)->delete();
    }


    public function deleteQuestionOptions(array $removedQuestionOptions) : void
    {
        QuestionOption::whereIn('id', $removedQuestionOptions)->delete();
    }


}
