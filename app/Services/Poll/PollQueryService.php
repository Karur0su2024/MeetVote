<?php

namespace App\Services\Poll;

use App\Models\Poll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\QuestionService;
use App\Services\TimeOptionService;

class PollQueryService
{

    public function __construct
    (
        protected TimeOptionService $timeOptionService,
        protected QuestionService $questionService,
    ) {}


    public function getPollArray($pollIndex = null): array
    {
        $poll = Poll::with('timeOptions', 'questions', 'questions.options')->find($pollIndex, ['*']) ?? new Poll();

        return [
            'pollIndex' => $poll->id ?? null,
            'title' => $poll->title ?? '',
            'description' => $poll->description ?? '',
            'deadline' => $poll->deadline ? Carbon::parse($poll->deadline)->format('Y-m-d') : null,
            'user' => [
                'posted_anonymously' => false,
                'name' => $poll->author_name ?? Auth::user()?->name,
                'email' => $poll->author_email ?? Auth::user()?->email,
            ],
            'settings' => [
                'anonymous' => (bool) $poll?->anonymous_votes,
                'comments' => (bool) $poll?->comments,
                'hide_results' => (bool) $poll?->hide_results,
                'invite_only' => (bool) $poll?->invite_only,
                'password' => [
                    'set' => $poll?->password ?? false,
                    'value' => '',
                ],
                'add_time_options' => (bool) $poll?->add_time_options,
                'edit_votes' => (bool) $poll?->edit_votes,
            ],
            'time_options' => $this->timeOptionService->getPollTimeOptions($poll),
            'questions' => $this->questionService->getPollQuestions($poll),
        ];
    }

}
