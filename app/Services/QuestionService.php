<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\PollQuestion;
use App\Models\QuestionOption;

class QuestionService
{
    // Metoda pro načtení otázek ankety
    // Pokud není anketa nastavena, vrátí prázdné pole
    // Pokud je anketa nastavena, vrátí pole otázek s možnostmi
    public function getPollQuestions(?Poll $poll): array
    {
        $questions = [];

        if (! Poll::where('id', $poll->id)->first()) {
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

    // Metoda pro uložení otázek do databáze
    // Pokud otázka již existuje, aktualizuje ji
    // Pokud otázka neexistuje, vytvoří ji
    public function saveQuestions(Poll $poll, array $questions): void
    {
        foreach ($questions as $question) {
            if (isset($question['id'])) {
                $newQuestion = PollQuestion::find($question['id']);

                if (! $newQuestion) {
                    throw new \Exception('Question not found');
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

    // Metoda pro uložení možností otázky do databáze
    // Pokud možnost otázky již existuje, aktualizuje ji
    // Pokud možnost otázky neexistuje, vytvoří ji
    public function saveQuestionOptions(PollQuestion $question, array $options): void
    {
        foreach ($options as $option) {
            if (isset($option['id'])) {
                $newOption = QuestionOption::find($option['id']);

                if (! $newOption) {
                    throw new \Exception('Question option not found');
                } else {
                    $newOption->update([
                        'text' => $option['text'],
                    ]);
                }
            } else {
                $question->options()->create([
                    'text' => $option['text'],
                ]);
            }
        }
    }

    // Metoda pro odstranění otázek a jejich možností
    public function deleteQuestions(array $removedQuestions): void
    {
        PollQuestion::whereIn('id', $removedQuestions)->delete();
    }

    // Metoda pro odstranění možností otázek
    public function deleteQuestionOptions(array $removedQuestionOptions): void
    {
        QuestionOption::whereIn('id', $removedQuestionOptions)->delete();
    }

    // Metoda pro kontrolu duplicitních otázek
    // Pokud otázka již existuje, vrátí true
    public function checkDupliciteQuestions(array $questions): bool
    {
        $questionText = [];
        // Kontrola duplicitních otázek
        foreach ($questions as $questionIndex => $question) {
            if ($this->checkDupliciteOptions($question['options'])) {
                return true;
            }
            $questionText[] = strtolower($question['text']);
        }

        return count($questionText) !== count(array_unique($questionText));
    }

    // Metoda pro kontrolu duplicitních možností
    // Pokud možnost již existuje, vrátí true
    private function checkDupliciteOptions(array $options): bool
    {
        $optionText = [];
        foreach ($options as $optionIndex => $option) {
            $optionText[] = strtolower($option['text']);
        }

        return count($optionText) !== count(array_unique($optionText));
    }
}
