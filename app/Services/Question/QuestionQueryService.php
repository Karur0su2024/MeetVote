<?php

namespace App\Services\Question;

use App\Models\Poll;
use App\Models\QuestionOption;

class QuestionQueryService
{
    /**
     * Metoda pro načtení otázek ankety
     * @param Poll $poll
     * @return array
     */
    public function getQuestionsArray(Poll $poll): array
    {
        $questions = [];

        if (!isset($poll->id)) {
            return $questions;
        }

        foreach ($poll->questions as $question) {
            $questionOptions = [];
            foreach ($question->options as $option) {
                $questionOptions[] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'score' => $this->getOptionScore($option),
                ];
            }

            $questions[] = [
                'id' => $question->id,
                'text' => $question->text,
                'options' => $questionOptions,
            ];
        }

        return $questions;
    }



    /**
     * Metoda pro získání celkového skóre možnosti otázky.
     * @param QuestionOption $option
     * @return int
     */
    private function getOptionScore(QuestionOption $option): int
    {
        $score = 0;
        foreach ($option->votes as $vote) {
            $score += $vote->preference;
        }
        return $score;
    }
}
