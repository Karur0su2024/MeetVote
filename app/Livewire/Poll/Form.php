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
    public PollForm $form;

    public ?Poll $poll;

    // Služby
    protected PollService $pollService;
    protected NotificationService $notificationService;

    public function boot(PollService $pollService, NotificationService $notificationService) {
        $this->pollService = $pollService;
        $this->notificationService = $notificationService;
    }

    // Konstruktor
    public function mount(?Poll $poll)
    {
        // Načtení dat ankety
        $this->poll = $poll;

        $this->form->loadForm($this->pollService->getPollData($poll));
        //dd($this->form);
    }

    public function submit()
    {

        try {
            $this->form->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors());
            return null;
        }

        $validatedData = $this->prepareValidatedDataArray($this->form->validate());

        if(!$validatedData) {
            $this->addError('error', 'An error occurred while validating the form.');
            return null;
        }
        if ($this->checkDuplicity($validatedData, $this->pollService)) {
            return null;
        }

        $poll = $this->savePoll($validatedData);



        if($poll == null) {
            dd("test");
            return null;
        }

        if($poll->created_at == $poll->updated_at) {
            if($poll->email){
                $notificationService = app(NotificationService::class);
                $notificationService->sendConfirmationEmail($poll);
            }
        }

        if ($poll) {
            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return redirect()->route('polls.show', $poll);
        }

    }

    // Úprava pole pro uložení do databáze
    private function prepareValidatedDataArray($validatedData): array
    {
        // Převod z dat do formátu pro uložení do databáze
        foreach ($validatedData['dates'] as $date) {
            foreach ($date as $option) {
                $validatedData['time_options'][] = $option;
            }
        }
        unset($validatedData['dates']);
        return $validatedData;
    }

        // Tohle taky přesunout do alpine.js
        // Kontrola duplicitních otázek a časových možností
        private function checkDuplicity($validatedData, PollService $pollService): bool
        {
            if ($pollService->getTimeOptionService()->checkDuplicity($validatedData['time_options'])) {
                $this->addError('form.dates', 'Duplicate time options are not allowed.');
                return true;
            }

            if ($pollService->getQuestionService()->checkDupliciteQuestions($validatedData['questions'])) {
                $this->addError('form.questions', 'Duplicate questions are not allowed.');
                return true;
            }

            return false;
        }



     // Metoda pro transakci a uložení ankety
     private function savePoll($validatedData): ?Poll
     {
         DB::beginTransaction();

         try {
             $poll = Poll::find($this->form->pollIndex); // Načtení ankety podle ID


             if ($poll) {
                 $poll = $this->pollService->updatePoll($poll, $validatedData); // Aktualizace ankety
             } else {
                 $poll = $this->pollService->createPoll($validatedData); // Vytvoření nové ankety
             }

             DB::commit();

             return $poll;
         } catch (PollException $e) {
             DB::rollBack();
             $this->addError('error', $e->getMessage());
             return null;
         } catch (\Exception $e) {
             dd($e);

             //$this->addError('error', 'An error occurred while saving the poll.');
             return null;
         }

     }

    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form');
    }
}
