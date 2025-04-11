<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use App\Models\Poll;

class WasEmailAlreadyUsed implements ValidationRule
{

    public function __construct(
        protected $email,
        protected $pollIndex
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $poll = Poll::find($this->pollIndex);
        $vote = null;

        if(Auth::guest()){
            $vote = $poll->votes->where('voter_email', $this->email)->first();

        }

        if($vote) {
            $fail('You already voted under this email.');
        }

    }
}
