<?php

namespace App\Rules;

use App\Services\PollService;
use App\Services\TimeOptionService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Poll;

class CheckIfTimeOptionExists implements ValidationRule
{
    public $pollIndex;
    protected TimeOptionService $timeOptionService;

    public function __construct($pollIndex, $timeOptionService)
    {
        $this->pollIndex = $pollIndex;
        $this->timeOptionService = $timeOptionService;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $newOption = $this->convertContentToText($value);

        $poll = Poll::find($this->pollIndex);

        $timeOptions = $this->timeOptionService->getPollTimeOptions($poll);

        foreach ($timeOptions as $option) {
            if($newOption === $this->convertContentToText($option)){
                $fail('Duplicate time options are not allowed.');
                return;
            }
        }
    }

    private function convertContentToText($option): string
    {
        return $option['date'].' '.strtolower(implode('', $option['content']));
    }

}
