<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Livewire\Component;
use App\Services\NotificationService;
use App\Exceptions\PollException;

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
        $validatedData = null;
        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            if($this->checkDuplicity($validatedData)){
                $this->dispatch('validation-failed', errors: $this->getErrors());
                return null;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('error', 'Došlo k chybě při validaci formuláře.');
            $this->checkDuplicity($validatedData);
            $this->dispatch('validation-failed', errors: $this->getErrors());
            throw $e;
        }




        if(!$validatedData) {
            $this->addError('error', 'An error occurred while validating the form.');
            $this->dispatch('validation-failed', errors: $this->getErrors());
        }

        if($this->checkDuplicity($validatedData)){
            $this->dispatch('validation-failed', errors: $this->getErrors());
            return null;
        }
        unset($validatedData['dates']);


        try {
            // Uložení do databáze
            $poll = $this->pollService->savePoll($validatedData, $this->poll->id ?? null);
            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return redirect()->route('polls.show', $poll);

        } catch (PollException $e) {
            // Pokud nastane výjimka PollException
            $this->addError('error', $e->getMessage());
            return null;

        } catch (\Exception $e) {
            // Pokud nastane jiná výjimka
            $this->addError('error', 'An error occurred while saving the poll.');
            return null;

        }
    }

    /**
     * Kontrola duplicitních otázek a časových možností
     * @param $validatedData
     * @param PollService $pollService
     * @return bool
     */
    private function checkDuplicity($validatedData): bool
    {
        $duplicatesDates = $this->pollService->getTimeOptionService()->checkDuplicityByDates($validatedData['dates']);
        $duplicatesQuestions = $this->pollService->getQuestionService()->checkDuplicateQuestions($validatedData['questions']);

        foreach ($duplicatesDates as $dateIndex) {
            $this->addError('form.dates.' . $dateIndex, 'Duplicate time options are not allowed.');
        }

        foreach ($duplicatesQuestions['each_question'] as $questionIndex) {
            $this->addError('form.questions.' . $questionIndex, 'Duplicate options are not allowed.');
        }

        if ($duplicatesQuestions['all_questions']) {
            $this->addError('form.questions', 'Duplicate questions titles are not allowed.');
        }

        return $duplicatesDates || $duplicatesQuestions['all_questions'] || $duplicatesQuestions['each_question'];

    }



    private function getErrors(): array
    {
        return $this->getErrorBag()->toArray();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.poll.form');
    }
}
