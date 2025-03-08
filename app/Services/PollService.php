<?php

namespace App\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Models\Poll;
use Illuminate\Support\Str;

class PollService
{

    public function loadPollData(Poll $poll) : array
    {
        return [
            'title' => $poll->title,
            'description' => $poll->description,
            'deadline' => $poll->deadline,
            'userName' => $poll->author_name,
            'userEmail' => $poll->author_email,
            'settings' => [
                'anonymous' => $poll->anonymous_votes == 1,
                'comments' => $poll->comments == 1,
                'hide_results' => $poll->hide_results == 1,
                'invite_only' => $poll->invite_only == 1,
                'password' => $poll->password,
            ],
        ];
    }


    public function createPoll(array $validatedData) : Poll
    {
        $poll = Poll::create([
            'title' => $validatedData['title'],
            'public_id' => Str::random(40),
            'admin_key' => Str::random(40),
            'author_name' => $validatedData['user_name'],
            'author_email' => $validatedData['user_email'],
            'user_id' => Auth::id(),
            'deadline' => $validatedData['deadline'],
            'description' => $validatedData['description'],
            'comments' => $validatedData['settings']['comments'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'invite_only' => $validatedData['settings']['invite_only'],
            'password' => $validatedData['settings']['password'],
            'status' => 'active',
        ]);

        return $poll;
    }


    public function updatePoll(Poll $poll, array $validatedData) : Poll
    {
        $poll->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'comments' => $validatedData['settings']['comments'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'invite_only' => $validatedData['settings']['invite_only'],
            'password' => $validatedData['settings']['password'],
        ]);

        return $poll;
    }



}
