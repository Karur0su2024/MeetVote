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

        $voteIndex = $this->getVoteIndex($poll);

        return [
            'user' => [
                'name' => Auth::user()->name ?? '',
                'email' => Auth::user()->email ?? '',
            ],
            'time_options' => $this->timeOptionQueryService->getVotingArray($poll, $voteIndex), // Pole časových možností
            'questions' => $this->questionQueryService->getVotingArray($poll, $voteIndex), // Pole otázek
            'vote_index' => $voteIndex, // Id existujícího hlasu pro případnou její změnu
        ];
    }


    public function getVoteIndex(Poll $poll): ?int
    {
        if(Auth::check()) {
            $vote = $poll->votes()->where('user_id', Auth::id())->first();
            if($vote) {
                return $vote->id;
            }
        }

        return null;
    }



}
