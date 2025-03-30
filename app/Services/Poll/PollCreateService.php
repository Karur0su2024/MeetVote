<?php

namespace App\Services\Poll;

use App\Events\PollCreated;
use App\Exceptions\PollException;
use App\Models\Poll;
use App\Services\PollService;
use App\Services\QuestionService;
use App\Services\TimeOptionService;
use Illuminate\Support\Facades\DB;

class PollCreateService
{

    public function __construct(
        protected TimeOptionService $timeOptionService,
        protected QuestionService $questionService,
    ) {}


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
            PollCreated::dispatchIf($newPoll, $poll);

            // Tohle je potřeba zabezpečit
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
