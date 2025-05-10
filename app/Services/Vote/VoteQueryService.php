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


    // Získaní dat pro hlasovací formulář
    public function getPollData($pollIndex): array
    {
        $poll = Poll::with(['timeOptions', 'questions', 'questions.options'])->findOrFail($pollIndex);

        $vote = $this->getVote($poll);


        return [
            'poll_index' => $poll->id,
            'user' => [
                'name' => ($poll->settings['anonymous_votes'] ?? false) ? 'Anonymous' : (Auth::user()->name ?? ''),
                'email' => Auth::user()->email ?? '',
            ],
            'message' => $vote->message ?? '',
            'time_options' => $this->timeOptionQueryService->getVotingArray($poll, $vote), // Pole časových možností
            'questions' => $this->questionQueryService->getVotingArray($poll, $vote), // Pole otázek
            'vote_index' => $vote->id ?? null, // Id existujícího odpovědi pokud je uživatel přihlášený a už hlasoval
        ];
    }


    // Získání existují odpovědi, pokud je existuje
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
