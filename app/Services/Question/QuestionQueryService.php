<?php

namespace App\Services\Question;

use App\Models\Poll;
use App\Models\QuestionOption;
use App\Models\Vote;

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
                    'picked_preference' => 0,
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


    // TODO: dočasné řešení
    // Ass jako associative, ne nic jiného :D
    public function getQuestionsAssArray(Poll $poll): array
    {
        $questions = [];

        if (!isset($poll->id)) {
            return $questions;
        }

        foreach ($poll->questions as $question) {
            $questionOptions = [];
            foreach ($question->options as $option) {
                $questionOptions[$option->id] = [
                    'id' => $option->id,
                    'text' => $option->text,
                    'score' => $this->getOptionScore($option),
                    'picked_preference' => 0,
                ];
            }

            $questions[$question->id] = [
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



    /**
     * Metoda pro získání dat o otázkách pro hlasování
     * Vratí pole s daty s otázkami
     * @param $data
     * @param $voteIndex
     * @return array
     */
    public function getVotingArray(Poll $poll, $vote = null): array
    {
        $pollQuestions = $this->getQuestionsAssArray($poll);

        foreach ($vote->questionOptions ?? [] as $questionOption) {
            $pollQuestions[$questionOption->poll_question_id]['options'][$questionOption->question_option_id]['picked_preference'] = $questionOption->preference;
        }

        return $pollQuestions;

    }

}
