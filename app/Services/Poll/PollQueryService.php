<?php

namespace App\Services\Poll;

use App\Models\Poll;
use App\Services\Question\QuestionQueryService;
use App\Services\TimeOptions\TimeOptionQueryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\QuestionService;
use App\Services\TimeOptionService;

class PollQueryService
{

    public function __construct
    (
        protected TimeOptionQueryService $timeOptionQueryService,
        protected QuestionQueryService $questionQueryService,
    ) {}

    public function getPollArray($pollIndex = null): array
    {
        $poll = Poll::with('timeOptions', 'questions', 'questions.options')->find($pollIndex, ['*']) ?? new Poll();

        return [
            'pollIndex' => $poll->id ?? null,
            'title' => $poll->title ?? '',
            'description' => $poll->description ?? '',
            'deadline' => $poll->deadline ? Carbon::parse($poll->deadline)->format('Y-m-d') : null,
            'timezone' => $poll->timezone ?? config('app.timezone'),
            'user' => [
                'posted_anonymously' => false,
                'name' => $poll->author_name ?? Auth::user()?->name,
                'email' => $poll->author_email ?? Auth::user()?->email,
            ],
            'settings' => $poll->settings ?? $this->getDefaultSettings(),
            'password' => [
                'enabled' => $poll?->password ? true : false,
                'set' => $poll?->password ?? null,
                'value' => '',
            ],
            'time_options' => $this->timeOptionQueryService->getTimeOptionsArray($poll),
            'questions' => $this->questionQueryService->getQuestionsArray($poll),
            'last_updated' => $poll->updated_at ?? null,
        ];
    }

    private function getDefaultSettings()
    {
        return [
            'comments' => false,
            'anonymous_votes' => false,
            'hide_results' => false,
            'add_time_options' => false,
            'invite_only' => false,
        ];
    }

}
