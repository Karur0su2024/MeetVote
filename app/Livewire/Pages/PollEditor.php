<?php

namespace App\Livewire\Pages;

use App\Exceptions\PollException;
use App\Livewire\Forms\PollEditorForm;
use App\Models\Poll;
use App\Services\PollService;
use Livewire\Component;

class PollEditor extends Component
{

    public PollEditorForm $form;
    public $pollIndex;

    /**
     * @param Poll|null $poll
     * @return void
     */
    public function mount(PollService $pollService, $pollIndex = null): void
    {
        $this->pollIndex = $pollIndex;
        $this->form->loadForm($pollService->getPollData($this->pollIndex));
    }

    /**
     * @return void
     */
    public function submit(PollService $pollService): void
    {
        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            $this->saveToDatabase($validatedData, $pollService);
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
    private function saveToDatabase(array $validatedData, PollService $pollService)
    {
        try {
            $poll = $pollService->savePoll($validatedData, $this->pollIndex ?? null);
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
