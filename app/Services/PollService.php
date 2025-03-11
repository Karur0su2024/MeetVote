<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PollService
{
    protected TimeOptionService $timeOptionService;

    protected QuestionService $questionService;

    public function getTimeOptionService(): TimeOptionService
    {
        return $this->timeOptionService;
    }

    public function getQuestionService(): QuestionService
    {
        return $this->questionService;
    }

    // Konstruktor
    public function __construct(TimeOptionService $timeOptionService, QuestionService $questionService)
    {
        // Inicializace služeb
        $this->timeOptionService = $timeOptionService;
        $this->questionService = $questionService;
    }

    // Metoda pro načtení dat ankety
    public function getPollData(?Poll $poll): array
    {

        return [
            'pollIndex' => $poll->id ?? null,
            'title' => $poll->title ?? 'abc',
            'description' => $poll->description ?? '',
            'deadline' => $poll->deadline ? Carbon::parse($poll->deadline)->format('Y-m-d') : null,
            'user' => [
                'name' => $poll->author_name ?? Auth::user()?->name,
                'email' => $poll->author_email ?? Auth::user()?->email,
            ],
            'settings' => [
                'anonymous' => (bool) $poll?->anonymous_votes,
                'comments' => (bool) $poll?->comments,
                'hide_results' => (bool) $poll?->hide_results,
                'invite_only' => (bool) $poll?->invite_only,
                'password' => $poll?->password ?? '',
            ],
            'questions' => $this->questionService->getPollQuestions($poll),
            'time_options' => $this->timeOptionService->getPollTimeOptions($poll),
        ];
    }

    // Metoda pro vytvoření nové ankety
    public function createPoll(array $validatedData): Poll
    {

        $poll = Poll::create([
            'title' => $validatedData['title'],
            'public_id' => Str::random(40),
            'admin_key' => Str::random(40),
            'author_name' => $validatedData['user']['name'],
            'author_email' => $validatedData['user']['email'],
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

        $this->questionService->saveQuestions($poll, $validatedData['questions'], []);

        $this->timeOptionService->saveTimeOptions($poll, $validatedData['time_options']);

        return $poll;
    }

    // Metoda pro aktualizaci ankety
    public function updatePoll(Poll $poll, array $validatedData): Poll
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


        $this->timeOptionService->saveTimeOptions($poll, $validatedData['time_options']);
        $this->questionService->saveQuestions($poll, $validatedData['questions']);

        $this->timeOptionService->deleteTimeOptions($validatedData['removed']['time_options']);
        $this->questionService->deleteQuestions($validatedData['removed']['questions']);
        $this->questionService->deleteQuestionOptions($validatedData['removed']['question_options']);

        return $poll;
    }

    // Metoda pro načtení časových možností pro hlasování
    public function getPollTimeOptions(?Poll $poll): array
    {
        if (! $poll) {
            return [];
        }

        foreach ($poll->timeOptions as $timeOption) {
            $timeOptions[] = [
                'id' => $timeOption->id,
                'start_time' => $timeOption->start_time,
                'end_time' => $timeOption->end_time,
                // 'chosen_preference' => 0,
            ];
        }

        return $timeOptions;
    }
}
