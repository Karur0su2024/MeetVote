<?php

namespace App\Other;

use App\Services\PollService;

trait MethodsForDelete
{
    /**
     * Kontrola duplicitních otázek a časových možností
     * @param $validatedData
     * @param PollService $pollService
     * @return bool
     */
    private function checkDuplicity($validatedData): bool
    {
        $duplicatesDates = $this->pollService->getTimeOptionService()->checkDuplicityByDates($validatedData['dates']);
        $duplicatesQuestions = $this->pollService->getQuestionService()->checkDuplicateQuestions($validatedData['questions']);


        foreach ($duplicatesQuestions['each_question'] as $questionIndex) {
            $this->addError('form.questions.' . $questionIndex, 'Duplicate options are not allowed.');
        }

        if ($duplicatesQuestions['all_questions']) {
            $this->addError('form.questions', 'Duplicate questions titles are not allowed.');
        }

        return $duplicatesDates || $duplicatesQuestions['all_questions'] || $duplicatesQuestions['each_question'];

    }

    /**
     * Metoda pro kontrolu duplicity časových možností.
     *
     * Kontroluje se i na server-side, tato metoda však bude v budoucnu pravděpodobně přesunuta jinam.
     * @param array $options
     * @return bool
     */
    public function checkDateDuplicity(array $options): bool
    {
        $toCheck = array_map(function ($item) {
            return $this->convertContentToText($item);
        }, $options);

        return count($options) !== count(array_unique($toCheck));
    }

    /**
     * Metoda pro kontrolu duplicity časových možností podle data.
     * @param array $dates
     * @return array
     */
    public function checkDuplicityByDates(array $dates): array
    {
        $duplicatesDates = [];

        foreach ($dates as $dateIndex => $date) {
            $optionArray = [];
            foreach($date as $option) {
                $optionArray[] = $this->convertContentToText($option);
            }

            if(count($optionArray) !== count(array_unique($optionArray))) {
                $duplicatesDates[] = $dateIndex;
            }
        }
        return $duplicatesDates;
    }


    public function checkDuplicateQuestions(array $questions): array
    {

        $duplicatesQuestions = [
            'all_questions' => false,
            'each_question' => [],
        ];

        $questionArray = [];
        foreach ($questions as $questionIndex => $question) {
            $optionArray = [];

            foreach ($question['options'] as $option) {
                $optionArray[] = strtolower($option['text']);
            }

            // Kontrola duplicitních možností
            if(count($optionArray) !== count(array_unique($optionArray))) {
                $duplicatesQuestions['each_question'][] = $questionIndex;
            }
            $questionArray[] = strtolower($question['text']);
        }
        $duplicatesQuestions['all_questions'] = count($questionArray) !== count(array_unique($questionArray));

        return $duplicatesQuestions;
    }

    /**
     * Metoda pro kontrolu duplicitních možností
     * @param array $options
     * @return bool
     */
    private function checkDuplicateOptions(array $options): bool
    {
        $optionText = [];
        foreach ($options as $option) {
            $optionText[] = strtolower($option['text']);
        }
        return count($optionText) !== count(array_unique($optionText));
    }



    /**
     * Metoda pro kontrolu duplicitních otázek
     * @param array $questions
     * @return bool
     */
    public function checkDuplicateQuestionsOld(array $questions): bool
    {
        $questionText = [];
        // Kontrola duplicitních otázek
        foreach ($questions as $question) {
            if ($this->checkDuplicateOptions($question['options'])) {
                return true;
            }
            $questionText[] = strtolower($question['text']);
        }

        return count($questionText) !== count(array_unique($questionText));
    }
}
