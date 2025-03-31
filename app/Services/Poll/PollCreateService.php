<?php

namespace App\Services\Poll;

use App\Events\PollCreated;
use App\Exceptions\PollException;
use App\Models\Poll;
use App\Services\Question\QuestionCreateService;
use App\Services\TimeOptions\TimeOptionCreateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PollCreateService
{

    public function __construct(
        protected TimeOptionCreateService $timeOptionCreateService,
        protected QuestionCreateService $questionCreateService,
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
            $poll = $this->createOrUpdatePoll($validatedData, $pollIndex);
            session()->push('poll_admin_keys.'.$poll->id, $poll->admin_key);
            return $poll;
        } catch (PollException $e) {
            DB::rollBack();
            throw new PollException($e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new PollException('An error occurred while saving the poll.');
        }
    }


    /**
     * @param mixed $pollIndex
     * @param $validatedData
     * @throws \Throwable
     */
    public function createOrUpdatePoll($validatedData, $pollIndex = null): Poll
    {
        DB::beginTransaction();
        $newPoll = false;

        $poll = Poll::with('timeOptions', 'questions', 'questions.options')->find($pollIndex, ['id', 'public_id']);
        $builtPoll = $this->buildPollArray($validatedData, $poll);

        if ($poll) {
            $poll->update($builtPoll);
        } else {
            $poll = Poll::create($builtPoll);
            $newPoll = true;
        }

        $this->timeOptionCreateService->save($poll, $validatedData['time_options'], $validatedData['removed']['time_options']);
        $this->questionCreateService->save($poll, $validatedData['questions'], $validatedData['removed']['questions'], $validatedData['removed']['question_options']);
        DB::commit();
        PollCreated::dispatchIf($newPoll, $poll);
        return $poll;
    }


    private function buildPollArray(array $validatedData, ?Poll $poll): array
    {

        return [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'comments' => $validatedData['settings']['comments'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'invite_only' => $validatedData['settings']['invite_only'],
            'password' => $this->setPassword($validatedData['settings']['password']),
            'edit_votes' => $validatedData['settings']['edit_votes'],
            'add_time_options' => $validatedData['settings']['add_time_options'],

            // Pro nové ankety
            'author_name' => ($poll->author_name ?? $validatedData['user']['posted_anonymously']) ? null : $validatedData['user']['name'],
            'author_email' => ($poll->author_email ?? $validatedData['user']['posted_anonymously']) ? null : $validatedData['user']['email'],
        ];
    }

    private function setPassword($password): ?string
    {

        if($password['set']){
            return $password['set'];
        }
        if($password['enabled']){
            return $password['value'] !== "" ? Hash::make($password['value']) : null;
        }

        return null;


    }


}
