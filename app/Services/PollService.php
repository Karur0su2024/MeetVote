<?php

namespace App\Services;

use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Models\Poll;
use Illuminate\Support\Str;
use App\Services\TimeOptionService;

class PollService
{

    protected TimeOptionService $timeOptionService;

    // Metoda pro načtení dat ankety
    public function getPollData(?Poll $poll) : array
    {
        $timeOptionService = new TimeOptionService();

        //dd($timeOptionService->loadTimeOptionsForPoll($poll));

        return [
            'title' => $poll->title ?? '',
            'description' => $poll->description ?? '',
            'deadline' => $poll->deadline ?? '',
            'user' => [
                'name' => $poll->author_name ?? Auth::user()?->name,
                'email' => $poll->author_email ?? Auth::user()?->email,
            ],
            'settings' => [
                'anonymous' => (bool)$poll?->anonymous_votes,
                'comments' => (bool)$poll?->comments,
                'hide_results' => (bool)$poll?->hide_results,
                'invite_only' => (bool)$poll?->invite_only,
                'password' => $poll?->password ?? '',
            ],
            'questions' => $this->getPollQuestions($poll),
            'timeOptions' => $timeOptionService->getTimeOptionsForPoll($poll),
        ];
    }


    // Metoda pro vytvoření nové ankety
    public function createPoll(array $validatedData) : Poll
    {
        return Poll::create([
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
    }


    // Metoda pro aktualizaci ankety
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


    // Metoda pro načtení časových možností pro hlasování
    public function getPollQuestions(?Poll $poll) : array
    {
        if(!$poll){
            return [];
        }
        else {
            $questions = [];
            foreach ($poll->questions as $question) {
                $questionOptions = [];

                // Načtení možností otázky
                foreach ($question->options as $option) {
                    $questionOptions[] = [
                        'id' => $option['id'],
                        'text' => $option['text'],
                    ];
                }

                // Načtení otázky do pole
                $questions[] = [
                    'id' => $question['id'],
                    'text' => $question['text'],
                    'options' => $questionOptions,
                ];
            }
            return $questions;
        }
    }


    // Metoda pro načtení časových možností pro hlasování
    public function getPollTimeOptions(?Poll $poll) : array
    {

        if(!$poll){

            return [];
        }


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
