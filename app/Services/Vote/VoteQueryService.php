<?php

namespace App\Services\Vote;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionQueryService;
use App\Models\Vote;

class VoteQueryService{

    public function __construct(
        protected TimeOptionQueryService $timeOptionQueryService,
        protected QuestionQueryService $questionQueryService,
    ) {}


    /**
     * Metoda pro získaní dat pro hlasování.
     * @param Poll $poll Anketa, pro kterou se získávají data.
     * @param $voteId / V případě nenullové hodnoty, se načte existující hlas i se zvolenými preferencemi.
     * @return array Pole s daty o hlasu.
     */
    public function getPollData(Poll $poll): array
    {
        $poll->load(['timeOptions', 'questions', 'questions.options']);

        $vote = $this->getVote($poll);



        return [
            'user' => [
                'name' => Auth::user()->name ?? '',
                'email' => Auth::user()->email ?? '',
            ],
            'message' => $vote->message ?? '',
            'time_options' => $this->timeOptionQueryService->getVotingArray($poll, $vote), // Pole časových možností
            'questions' => $this->questionQueryService->getVotingArray($poll, $vote), // Pole otázek
            'vote_index' => $vote->id ?? null, // Id existujícího hlasu pro případnou její změnu
        ];
    }


    public function getVote(Poll $poll): ?Vote
    {
        if(Auth::check()) {
            $vote = $poll->votes()->where('user_id', Auth::id())->first();
            if($vote) {
                return $vote;
            }
        }

        return null;
    }



}
