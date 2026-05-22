<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NoQuestionDuplicates implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $questionArray = [];
        foreach ($value as $questionIndex => $question) {
            $questionArray[] = strtolower($question['text']);
        }

        if (count($questionArray) !== count(array_unique($questionArray))) {
            $fail(__('pages/poll-editor.questions.messages.error.duplicate_titles'));

            return;
        }
    }
}
