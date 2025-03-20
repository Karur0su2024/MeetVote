<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Livewire\Component;
use App\ToAlpine\Form\TimeOptionsToAlpine;
use App\ToAlpine\Form\QuestionsToAlpine;
use App\Services\NotificationService;
use App\Exceptions\PollException;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    /**
     * @var PollForm
     */
    public PollForm $form;

    /**
     * @var Poll|null
     */
    public ?Poll $poll;

    /**
     * @var PollService
     */
    protected PollService $pollService;
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @param PollService $pollService
     * @param NotificationService $notificationService
     * @return void
     */
    public function boot(PollService $pollService, NotificationService $notificationService): void
    {
        $this->pollService = $pollService;
        $this->notificationService = $notificationService;
    }

    /**
     * @param Poll|null $poll
     * @return void
     */
    public function mount(?Poll $poll)
    {
        $this->poll = $poll;
        $this->form->loadForm($this->pollService->getPollData($poll));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|void|null
     */
    public function submit()
    {
        $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());

        if(!$validatedData) {
            $this->addError('error', 'An error occurred while validating the form.');
            return null;
        }


        if ($this->checkDuplicity($validatedData, $this->pollService)) {
            return null;
        }

        try {
            $poll = $this->pollService->savePoll($validatedData, $this->poll->id ?? null);
            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return redirect()->route('polls.show', $poll);
        } catch (PollException $e) {
            $this->addError('error', $e->getMessage());
            return null;
        } catch (\Exception $e) {
            $this->addError('error', 'An error occurred while saving the poll.');
            return null;
        }
    }

    // Úprava pole pro uložení do databáze


        // Tohle taky přesunout do alpine.js
        // Kontrola duplicitních otázek a časových možností
    /**
     * @param $validatedData
     * @param PollService $pollService
     * @return bool
     */
    private function checkDuplicity($validatedData, PollService $pollService): bool
        {
            if ($pollService->getTimeOptionService()->checkDuplicity($validatedData['time_options'])) {
                $this->addError('form.dates', 'Duplicate time options are not allowed.');
                return true;
            }

            if ($pollService->getQuestionService()->checkDuplicateQuestions($validatedData['questions'])) {
                $this->addError('form.questions', 'Duplicate questions are not allowed.');
                return true;
            }

            return false;
        }



     // Metoda pro transakci a uložení ankety

    /**
     * @param $validatedData
     * @return Poll|null
     * @throws \Throwable
     */
//    private function savePoll($validatedData): ?Poll
//     {
//         DB::beginTransaction();
//
//         try {
//             $poll = Poll::find($this->form->pollIndex); // Načtení ankety podle ID
//
//             if ($poll) {
//                 $poll = $this->pollService->updatePoll($poll, $validatedData); // Aktualizace ankety
//             } else {
//                 $poll = $this->pollService->createPoll($validatedData); // Vytvoření nové ankety
//             }
//
//             DB::commit();
//
//             return $poll;
//         } catch (PollException $e) {
//             DB::rollBack();
//             $this->addError('error', $e->getMessage());
//             return null;
//         } catch (\Exception $e) {
//             //$this->addError('error', 'An error occurred while saving the poll.');
//             return null;
//         }
//
//     }




    // Renderování komponenty

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.poll.form');
    }
}
