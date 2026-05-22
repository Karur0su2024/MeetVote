<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NoQuestionOptionDuplicates implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $optionsText = [];

        foreach ($value as $option) {
            $optionsText[] = strtolower($option['text']);
        }

        if (count($optionsText) !== count(array_unique($optionsText))) {
            $fail(__('pages/poll-editor.questions.messages.error.duplicate_options'));

            return;
        }
    }
}
