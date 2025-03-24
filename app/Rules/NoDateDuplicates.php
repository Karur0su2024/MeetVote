<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoDateDuplicates implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $duplicatesDates = [];

        $optionArray = [];
        foreach ($value as $option) {
            $optionArray[] = $this->convertContentToText($option);
        }
        if(count($optionArray) !== count(array_unique($optionArray))) {
            $fail('Duplicate time options are not allowed.');
            return;
        }
    }


    private function convertContentToText($option): string
    {
        return $option['date'].' '.strtolower(implode('-', $option['content']));
    }
}
