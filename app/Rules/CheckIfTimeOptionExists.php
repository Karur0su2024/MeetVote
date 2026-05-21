<?php

namespace App\Rules;

use App\Models\Poll;
use App\Services\TimeOptions\TimeOptionQueryService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckIfTimeOptionExists implements ValidationRule
{
    public function __construct(public $pollIndex) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $newOption = $this->convertContentToText($value);

        $poll = Poll::find($this->pollIndex);

        $timeOptions = app(TimeOptionQueryService::class)->getTimeOptionsArray($poll);

        foreach ($timeOptions as $option) {
            if ($newOption === $this->convertContentToText($option)) {
                $fail(__('pages/poll-editor.time_options.error_messages.duplicate_options'));

                return;
            }
        }
    }

    private function convertContentToText($option): string
    {
        $content = ($option['type'] === 'time') ? $option['content']['start'].' - '.$option['content']['end'] : $option['content']['text'];

        return $option['date'].' '.strtolower($content);
    }
}
