<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\PollCreated;
use Carbon\Carbon;
use App\Exceptions\PollException;
use Illuminate\Support\Facades\Hash;

class PollService
{
    protected TimeOptionService $timeOptionService;
    protected QuestionService $questionService;


    /**
     * @param TimeOptionService $timeOptionService
     * @param QuestionService $questionService
     */
    public function __construct(TimeOptionService $timeOptionService, QuestionService $questionService)
    {
        // Inicializace služeb
        $this->timeOptionService = $timeOptionService;
        $this->questionService = $questionService;
    }


    /**
     * Načte data ankety a vrátí je jako pole.
     * @param Poll|null $poll
     * @return array
     */
    public function getPollData($pollIndex = null): array
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


    /**
     * @param $validatedData
     * @param $pollIndex
     * @return Poll|null
     * @throws \Throwable
     */
    public function savePoll($validatedData, $pollIndex = null): Poll
    {
        try {
            $newPoll = false;
            DB::beginTransaction();

            $poll = Poll::with('timeOptions', 'questions', 'questions.options')->find($pollIndex, ['id', 'public_id']);


            $builtPoll = $this->buildPoll($validatedData, $poll);

            if ($poll) {
                $poll->update($builtPoll);
            } else {
                $poll = Poll::create($builtPoll);
                $newPoll = true;
            }
            $this->timeOptionService->saveTimeOptions($poll, $validatedData['time_options'], $validatedData['removed']['time_options']);
            $this->questionService->saveQuestions($poll, $validatedData['questions'], $validatedData['removed']['questions'], $validatedData['removed']['question_options']);


            DB::commit();

            if($newPoll) {
                event(new PollCreated($poll));
            }

            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return $poll;
        } catch (PollException $e) {
            DB::rollBack();
            throw new PollException($e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new PollException('An error occurred while saving the poll.');
        }
    }

    private function buildPoll(array $validatedData, ?Poll $poll): array
    {
        return [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'comments' => $validatedData['settings']['comments'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'invite_only' => $validatedData['settings']['invite_only'],
            'password' => $validatedData['settings']['password']['value'] ? bcrypt($validatedData['settings']['password']['value']) : null,
            'edit_votes' => $validatedData['settings']['edit_votes'],
            'add_time_options' => $validatedData['settings']['add_time_options'],

            // Pro nové ankety
            'author_name' => ($poll->author_name ?? $validatedData['user']['posted_anonymously']) ? null : $validatedData['user']['name'],
            'author_email' => ($poll->author_email ?? $validatedData['user']['posted_anonymously']) ? null : $validatedData['user']['email'],
        ];
    }
}
