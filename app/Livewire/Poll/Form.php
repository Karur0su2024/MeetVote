<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use App\ToAlpine\Form\TimeOptionsToAlpine;
use App\ToAlpine\Form\QuestionsToAlpine;

class Form extends Component
{
    use TimeOptionsToAlpine;

    use QuestionsToAlpine;

    public PollForm $form;

    public ?Poll $poll;

    // Služby
    protected PollService $pollService;

    public function boot(PollService $pollService) {
        $this->pollService = $pollService;
    }

    // Konstruktor
    public function mount(?Poll $poll)
    {
        // Načtení dat ankety
        $this->poll = $poll;
        $this->form->loadForm($this->pollService->getPollData($poll));
    }

    public function submit()
    {
        $validatedData = $this->prepareValidatedDataArray($this->form->validate());
        if(!$validatedData) {
            $this->addError('error', 'An error occurred while validating the form.');
            return null;
        }
        if ($this->checkDuplicity($validatedData, $pollService)) {
            return null;
        }

        $poll = $this->savePoll($validatedData, $pollService);

        if($poll == null) {
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
     private function savePoll($validatedData, PollService $pollService): ?Poll
     {
         DB::beginTransaction();

         try {
             $poll = Poll::find($this->pollIndex); // Načtení ankety podle ID

             if ($poll) {
                 $poll = $pollService->updatePoll($poll, $validatedData); // Aktualizace ankety
             } else {
                 $poll = $pollService->createPoll($validatedData); // Vytvoření nové ankety
             }

             DB::commit();

             return $poll;
         } catch (PollException $e) {
             DB::rollBack();
             $this->addError('error', $e->getMessage());
             return null;
         } catch (\Exception $e) {
             $this->addError('error', 'An error occurred while saving the poll.');
             return null;
         }

     }

    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form');
    }
}
