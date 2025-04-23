<?php

namespace App\Services\Poll;

use App\Events\PollCreated;
use App\Exceptions\PollException;
use App\Models\Poll;
use App\Services\Question\QuestionCreateService;
use App\Services\TimeOptions\TimeOptionCreateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PollCreateService
{

    public function __construct(
        protected TimeOptionCreateService $timeOptionCreateService,
        protected QuestionCreateService   $questionCreateService,
    )
    {
    }

    public function savePoll($validatedData, $pollIndex = null): Poll
    {
        try {
            $poll = $this->createOrUpdatePoll($validatedData, $pollIndex);
            session()->put('poll_admin_keys.' . $poll->id, $poll->admin_key);
            return $poll;
        } catch (PollException $e) {
            DB::rollBack();
            throw new PollException($e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new PollException('An error occurred while saving the poll.');
        }
    }


    public function createOrUpdatePoll($validatedData, $pollIndex = null): ?Poll
    {
        $poll = Poll::with('timeOptions', 'questions', 'questions.options')->find($pollIndex, ['id', 'public_id']);
        $newPoll = !$poll;

        DB::beginTransaction();

        if ($newPoll) {
            $poll = Poll::create($this->buildPollArray($validatedData, $poll));
        } else {
            $poll->update($this->buildPollArray($validatedData, $poll));
            $poll->refresh();
        }

        $this->timeOptionCreateService->save($poll, $validatedData['time_options'], $validatedData['removed']['time_options']);
        $this->questionCreateService->save($poll, $validatedData['questions'], $validatedData['removed']['questions'], $validatedData['removed']['question_options']);
        DB::commit();
        PollCreated::dispatchIf($newPoll, $poll);
        return $poll;

    }


    private function buildPollArray(array $validatedData, ?Poll $poll): array
    {
        $newPoll = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'] !== '' ? $validatedData['deadline'] : null,
            'timezone' => $validatedData['timezone'] ?? config('app.timezone'),
            'settings' => $validatedData['settings'] ?? [],
            'password' => $this->setPassword($validatedData['password']),
        ];

        if(!$poll){
            $newPoll['author_name'] = Auth::user() ? Auth::user()->name : $validatedData['user']['name'];
            $newPoll['author_email'] = Auth::user() ? Auth::user()->email : $validatedData['user']['email'];
        }


        return $newPoll;
    }

    private function setPassword($password): ?string
    {

        if ($password['set']) {
            return $password['set'];
        }
        return $password['value'] !== "" ? Hash::make($password['value']) : null;

    }


}
