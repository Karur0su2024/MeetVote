<?php

namespace App\Rules;

use App\Services\PollService;
use App\Services\TimeOptions\TimeOptionQueryService;
use App\Services\TimeOptionService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Poll;

class CheckIfTimeOptionExists implements ValidationRule
{
    public function __construct(public $pollIndex)
    {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {


        $newOption = $this->convertContentToText($value);

        $poll = Poll::find($this->pollIndex);

        $timeOptions = app(TimeOptionQueryService::class)->getTimeOptionsArray($poll);

        foreach ($timeOptions as $option) {
            if($newOption === $this->convertContentToText($option)){
                $fail('Duplicate time options are not allowed.');
                return;
            }
        }
    }

    private function convertContentToText($option): string
    {
        $content = ($option['type'] === 'time') ? $option['content']['start'] . ' - ' . $option['content']['end'] : $option['content']['text'];

        return $option['date'].' '.strtolower($content);
    }

}
