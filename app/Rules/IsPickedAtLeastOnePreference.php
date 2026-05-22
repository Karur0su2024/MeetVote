<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IsPickedAtLeastOnePreference implements ValidationRule
{
    public function __construct(
        protected $timeOptions,
        protected $questions,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $picked = false;
        foreach ($this->timeOptions ?? [] as $timeOption) {
            if ($timeOption['picked_preference'] !== 0) {
                return;
            }
        }

        foreach ($this->questions ?? [] as $question) {
            foreach ($question['options'] as $option) {
                if ($option['picked_preference'] !== 0) {
                    return;
                }
            }
        }

        $fail(__('pages/poll-show.voting.messages.errors.no_option_selected'));
    }
}
