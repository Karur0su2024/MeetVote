<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\PollEditorForm;
use App\Models\Poll;
use App\Services\PollService;
use Livewire\Component;
use App\Services\NotificationService;
use App\Exceptions\PollException;

class PollEditor extends Component
{

    public PollEditorForm $form;
    public $pollIndex;
    protected PollService $pollService;


    /**
     * @param PollService $pollService
     * @return void
     */
    public function boot(PollService $pollService): void
    {
        $this->pollService = $pollService;
    }

    /**
     * @param Poll|null $poll
     * @return void
     */
    public function mount($pollIndex = null): void
    {
        $this->pollIndex = $pollIndex;
        $this->form->loadForm($this->pollService->getPollData($this->pollIndex));
    }

    /**
     * @return void
     */
    public function submit()
    {
        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            $this->saveToDatabase($validatedData);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed', errors: $this->getErrors());
            throw $e;
        }
    }

    /**
     * Uloží data do databáze
     *
     * @param array $validatedData
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function saveToDatabase(array $validatedData)
    {
        try {
            $poll = $this->pollService->savePoll($validatedData, $this->pollIndex ?? null);
            return redirect()->route('polls.show', ['poll' => $poll->public_id]);
        } catch (PollException $e) {
            $this->addError('error', $e->getMessage());
            return null;
        } catch (\Exception $e) {;
            $this->addError('error', 'An error occurred while saving the poll.');
            return null;
        }
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
        return view('livewire.pages.poll-editor');
    }
}
