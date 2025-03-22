<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\PollCreated;
use Carbon\Carbon;
use App\Exceptions\PollException;

class PollService
{
    /**
     * @var TimeOptionService
     */
    protected TimeOptionService $timeOptionService;
    /**
     * @var QuestionService
     */
    protected QuestionService $questionService;

    /**
     * @return TimeOptionService
     */
    public function getTimeOptionService(): TimeOptionService
    {
        return $this->timeOptionService;
    }

    /**
     * @return QuestionService
     */
    public function getQuestionService(): QuestionService
    {
        return $this->questionService;
    }


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
    public function getPollData(Poll $poll): array
    {
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
                'password' => $poll?->password ?? '',
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
            DB::beginTransaction();
            $poll = Poll::find($pollIndex); // Načtení ankety podle ID
            if ($poll) {
                $poll = $this->updatePoll($poll, $validatedData); // Aktualizace ankety
            } else {
                $poll = $this->createPoll($validatedData);
                event(new PollCreated($poll));
            }
            DB::commit();
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
     * Metoda pro vytvoření nové ankety
     * @param array $validatedData
     * @return Poll
     * @throws PollException
     */
    public function createPoll(array $validatedData): Poll
    {
        try {
            $poll = Poll::create([
                'title' => $validatedData['title'],
                'author_name' => $validatedData['user']['posted_anonymously'] ? null : $validatedData['user']['name'],
                'author_email' => $validatedData['user']['posted_anonymously'] ? null : $validatedData['user']['email'],
                'deadline' => $validatedData['deadline'],
                'description' => $validatedData['description'],
                'comments' => $validatedData['settings']['comments'],
                'anonymous_votes' => $validatedData['settings']['anonymous'],
                'hide_results' => $validatedData['settings']['hide_results'],
                'invite_only' => $validatedData['settings']['invite_only'],
                'password' => bcrypt($validatedData['settings']['password']),
                'edit_votes' => $validatedData['settings']['edit_votes'],
                'add_time_options' => $validatedData['settings']['add_time_options'],
            ]);


            $this->timeOptionService->saveTimeOptions($poll, $validatedData['time_options']);
            $this->questionService->saveQuestions($poll, $validatedData['questions']);


            return $poll;
        }
        catch (\Exception $e) {
            throw new PollException('An error occurred while creating the poll.');
        }
    }

    /**
     * Metoda pro aktualizaci ankety
     * @param Poll $poll
     * @param array $validatedData
     * @return Poll
     * @throws PollException
     */
    public function updatePoll(Poll $poll, array $validatedData): Poll
    {
        if ($poll->status !== 'active') {
            throw new PollException('You cannot edit a closed poll.');
        }

        try {
            $poll->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'deadline' => $validatedData['deadline'],
                'anonymous_votes' => $validatedData['settings']['anonymous'],
                'comments' => $validatedData['settings']['comments'],
                'hide_results' => $validatedData['settings']['hide_results'],
                'invite_only' => $validatedData['settings']['invite_only'],
                'password' => $validatedData['settings']['password'],
                'edit_votes' => $validatedData['settings']['edit_votes'],
                'add_time_options' => $validatedData['settings']['add_time_options'],
            ]);

        } catch (\Exception $e) {
            throw new PollException('An error occurred while updating the poll');
        }

        // Zde se provede vytvoření/aktualizace časových možností a otázek
        try {
            $this->timeOptionService->deleteTimeOptions($validatedData['removed']['time_options']);
            $this->questionService->deleteQuestions($validatedData['removed']['questions']);
            $this->questionService->deleteQuestionOptions($validatedData['removed']['question_options']);
            $this->timeOptionService->saveTimeOptions($poll, $validatedData['time_options']);
            $this->questionService->saveQuestions($poll, $validatedData['questions']);
        } catch (\Exception $e) {
            throw new PollException($e);
        }

        return $poll;
    }
}
