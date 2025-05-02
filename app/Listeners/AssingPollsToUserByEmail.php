<?php

namespace App\Listeners;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssingPollsToUserByEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;

        $polls = Poll::where('author_email', $user->email)->get();

        foreach ($polls as $poll) {
            $poll->user_id = $user->id;
            $poll->save();
        }

        $votes = Vote::where('voter_email', $user->email)->get();


    }
}
