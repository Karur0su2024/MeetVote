<?php

namespace App\Livewire\Pages;

use App\Exceptions\PollException;
use App\Livewire\Forms\PollEditorForm;
use App\Models\Poll;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PollEditor extends Component
{

    public PollEditorForm $form;
    public $pollIndex;
    public $poll;

    /**
     * @return void
     */
    public function mount(PollQueryService $pollQueryService, $pollIndex = null): void
    {
        $this->pollIndex = $pollIndex;
        $this->poll = Poll::where('id', $pollIndex)->first();
        $this->form->loadForm($pollQueryService->getPollArray($this->pollIndex));
    }

    /**
     */
    public function submit(PollCreateService $pollCreateService)
    {

        if(!$this->canUpdate()){
            $this->addError('error', 'The poll has been updated by another user. Please refresh the page.');
            return;
        }



        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            $poll = $pollCreateService->savePoll($validatedData, $this->pollIndex);
            return redirect()->route('polls.show', ['poll' => $poll->public_id]);
        } catch (ValidationException $e) {
            dd($e->errors());
            $this->dispatch('validation-failed', errors: $e->errors());
            throw $e;
        } catch (PollException $e) {
            $this->addError('error', $e->getMessage());
            return null;
        } catch (Exception $e) {;
            $this->addError('error', 'An error occurred while saving the poll.');
            return null;
        }

    }

    private function canUpdate(): bool
    {
        if ($this->pollIndex) {
            $pollUpdated = Poll::find($this->pollIndex, ['updated_at']);
            if($pollUpdated->updated_at !== $this->form->lastUpdated){
                return false;
            }
        }
        return true;
    }

    /**
     */
    public function render()
    {
        return view('livewire.pages.poll-editor');
    }
}
