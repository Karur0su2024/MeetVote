<?php

namespace App\Livewire\Pages;

use App\Exceptions\PollException;
use App\Livewire\Forms\PollEditorForm;
use App\Models\Poll;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use Livewire\Component;

class PollEditor extends Component
{

    public PollEditorForm $form;
    public $pollIndex;

    /**
     * @return void
     */
    public function mount(PollQueryService $pollQueryService, $pollIndex = null): void
    {
        $this->pollIndex = $pollIndex;
        $this->form->loadForm($pollQueryService->getPollArray($this->pollIndex));
    }

    /**
     */
    public function submit(PollCreateService $pollCreateService)
    {
        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            $poll = $pollCreateService->savePoll($validatedData, $this->pollIndex);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed', errors: $this->getErrors());
            throw $e;
            return;
        } catch (PollException $e) {
            $this->addError('error', $e->getMessage());
            return;
        } catch (\Exception $e) {;
            $this->addError('error', 'An error occurred while saving the poll.');
            return;
        }

        return redirect()->route('polls.show', ['poll' => $poll->public_id]);
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
