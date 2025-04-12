<?php

namespace App\Services\Question;

use App\Exceptions\PollException;
use App\Models\Poll;
use App\Models\PollQuestion;
use App\Models\QuestionOption;

class QuestionCreateService
{
    public function __construct()
    {
    }

    /**
     * Metoda pro uložení otázek do databáze
     * @param Poll $poll
     * @param array $questions
     * @return void
     * @throws \Exception
     */
    public function save(Poll $poll, array $questions, array $removedQuestions, array $removedQuestionOptions): void
    {
        $this->deleteQuestions($removedQuestions);
        $this->deleteQuestionOptions($removedQuestionOptions);

        foreach ($questions as $question) {
            $this->saveQuestion($question, $poll);
        }
    }


    private function saveQuestion(array $question, $poll)
    {
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


    /**
     * Metoda pro uložení možností otázky do databáze.
     * Pokud možnost otázky již existuje, aktualizuje ji.
     * Pokud možnost otázky neexistuje, vytvoří ji.
     * @param PollQuestion $question
     * @param array $options
     * @return void
     * @throws \Exception
     */
    private function saveQuestionOptions(PollQuestion $question, array $optionsToSave): void
    {
        foreach ($optionsToSave as $optionToSave) {
            if (isset($optionToSave['id'])) {
                $option = QuestionOption::find($optionToSave['id']);
                if (!$option) {
                    throw new PollException('Question option not found. Please try again.');
                }

                if($option->score !== 0) {
                    continue;
                }

                $option->update([
                    'text' => $optionToSave['text'],
                ]);
            } else {
                $question->options()->create([
                    'text' => $optionToSave['text'],
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
        if(count($removedQuestions) === 0) {
            return;
        }
        PollQuestion::whereIn('id', $removedQuestions)->delete();
    }

    /**
     * Metoda pro odstranění možností otázek
     * @param array $removedQuestionOptions
     * @return void
     */
    public function deleteQuestionOptions(array $removedQuestionOptions): void
    {
        if(count($removedQuestionOptions) === 0) {
            return;
        }
        QuestionOption::whereIn('id', $removedQuestionOptions)->delete();
    }
}
