<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\PollQuestion;
use App\Models\QuestionOption;
use App\Exceptions\PollException;

class QuestionService
{
    /**
     * Metoda pro načtení otázek ankety
     * @param Poll $poll
     * @return array
     */
    public function getPollQuestions(Poll $poll): array
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
     * Metoda pro uložení otázek do databáze
     * @param Poll $poll
     * @param array $questions
     * @return void
     * @throws \Exception
     */
    public function saveQuestions(Poll $poll, array $questions, array $removedQuestions, array $removedQuestionOptions): void
    {
        $this->deleteQuestions($removedQuestions);
        $this->deleteQuestionOptions($removedQuestionOptions);


        foreach ($questions as $question) {
            if (isset($question['id'])) {
                $newQuestion = PollQuestion::find($question['id']);

                if (!$newQuestion) {
                    throw new PollException('Question not found. Please try again.');
                } else {
                    $newQuestion->update([
                        'text' => $question['text'],
                    ]);
                }
            } else {
                $newQuestion = $poll->questions()->create([
                    'text' => $question['text'],
                ]);
            }

            $this->saveQuestionOptions($newQuestion, $question['options']);
        }
    }

    /**
     * Metoda pro uložení možností otázky do databáze.
     * Pokud možnost otázky již existuje, aktualizuje ji.
     * Pokud možnost otázky neexistuje, vytvoří ji.
     * @param PollQuestion $question
     * @param array $options
     * @return void
     * @throws \Exception
     */
    public function saveQuestionOptions(PollQuestion $question, array $options): void
    {
        foreach ($options as $option) {
            if (isset($option['id'])) {
                $newOption = QuestionOption::find($option['id']);
                if (!$newOption) {
                    throw new PollException('Question option not found. Please try again.');
                }
                $newOption->update([
                    'text' => $option['text'],
                ]);
            } else {
                $question->options()->create([
                    'text' => $option['text'],
                ]);
            }
        }
    }

    /**
     * Metoda pro odstranění otázek a jejich možností
     * @param array $removedQuestions
     * @return void
     */
    public function deleteQuestions(array $removedQuestions): void
    {
        PollQuestion::whereIn('id', $removedQuestions)->delete();
    }

    /**
     * Metoda pro odstranění možností otázek
     * @param array $removedQuestionOptions
     * @return void
     */
    public function deleteQuestionOptions(array $removedQuestionOptions): void
    {
        QuestionOption::whereIn('id', $removedQuestionOptions)->delete();
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
