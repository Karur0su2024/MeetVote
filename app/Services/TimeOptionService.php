<?php

namespace App\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Models\Poll;
use Illuminate\Support\Str;

class PollService
{
    public function loadTimeOptionsForPoll(Poll $poll) : array
    {
        $timeOptions = [];
        foreach ($poll->timeOptions as $timeOption) {
            $timeOptions[] = [
                'id' => $timeOption->id,
                'start_time' => $timeOption->start_time,
                'end_time' => $timeOption->end_time,
                'chosen_preference' => 0,
            ];
        }
        return $timeOptions;
    }

}
