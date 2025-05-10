<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionQueryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\VoteTimeOption;

class PollResultsService
{

    public function __construct(
        protected TimeOptionQueryService $timeOptionQueryService,
        protected QuestionQueryService   $questionQueryService,
    )
    {
    }

    // Získání výsledků ankety
    public function getResults($poll): array
    {

        $timeOptions = $this->getTimeOptionsResultsArray($this->timeOptionQueryService->getTimeOptionsArray($poll), $this->getPreferenceData($poll));
        $questionArray = $this->getQuestionResultsArray($this->questionQueryService->getQuestionsArray($poll));

        return [
            'timeOptions' => [
                'options' => $timeOptions,
                'selected' => 0,
            ],
            'questions' => $questionArray,
        ];

    }

    // Získání dat časových možností pro výsledky ankety
    private function getTimeOptionsResultsArray($timeOptions, $preferences): array
    {
        $timeOptions = $this->addPreferencesToTimeOptions($timeOptions, $preferences['timeOptions']);
        return $this->sortByScore($timeOptions);
    }

    // Získání dat otázek pro výsledky ankety
    private function getQuestionResultsArray($questions): array
    {
        $questionArray = [];

        foreach ($questions as $question) {
            $options = $question['options'];
            $options = $this->sortByScore($options);

            $questionArray[] = [
                'id' => $question['id'],
                'text' => $question['text'],
                'options' => $options,
                'selected' => 0,
            ];
        }

        return $questionArray;
    }

    // Seřazení podle bodového ohodnocení pomocí usort
    private function sortByScore($array): array
    {
        usort($array, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $array;

    }

    // Získání dat konkrétní odpovědi uživatele, pokud již hlasoval
    public function getUserVote($poll): ?Vote
    {
        $vote = null;

        if(!session()->has('poll.' . $poll->id . '.vote')){
            session()->remove('poll.' . $poll->id . '.vote');
        }

        if (Auth::check()) {
            $vote = Vote::with(['timeOptions.timeOption', 'questionOptions.questionOption.pollQuestion'])
                ->where('poll_id', $poll->id)
                ->where('user_id', Auth::id())
                ->first();
        }
        else {
            $vote = $poll->votes()->where('id', session()->get('poll.' . $poll->id . '.vote') ?? null)->first();
        }

        return $vote;

    }


    // Získání dat preferencí
    public function getPreferenceData($poll): array
    {
        $votes = $poll->votes;

        if ($poll->settings['anonymous_votes'] ?? false) {
            foreach ($votes as $vote) {
                $vote->voter_name = 'Anonymous';
            }
        }

        return $this->setNotZeroPreferences($votes);

    }

    // Nastavení časových možností a otázek se všemi preferencemi
    private function setNotZeroPreferences($votes): array
    {
        $preferences = [
            'timeOptions' => [],
            'questions' => [],
        ];

        foreach ($votes as $vote) {

            foreach ($vote->timeOptions as $timeOption) {
                $preferences['timeOptions'][$timeOption->time_option_id][$timeOption->preference][] = $vote->voter_name;
            }

            foreach ($vote->questionOptions as $questionOption) {
                $preferences['questions'][$questionOption->poll_question_id][$questionOption->question_option_id][$questionOption->preference][] =
                    $vote->voter_name;
            }
        }
        return $preferences;
    }

    // Přiřazení jednotlivých typů preferencí k časovým možnostem
    private function addPreferencesToTimeOptions($timeOptions, $preferences): array
    {
        foreach ($timeOptions as $key => $timeOption) {
            $timeOptions[$key]['preferences'] = [
                2 => $preferences[$timeOption['id']][2] ?? [],
                1 => $preferences[$timeOption['id']][1] ?? [],
                -1 => $preferences[$timeOption['id']][-1] ?? [],
            ];
        }

        return $timeOptions;
    }

}
