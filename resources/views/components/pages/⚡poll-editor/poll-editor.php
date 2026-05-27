<?php

use Livewire\Component;
use App\Exceptions\PollException;
use App\Livewire\Forms\PollEditorForm;
use App\Models\Poll;
use App\Services\Poll\PollCreateService;
use App\Services\Poll\PollQueryService;
use Illuminate\Validation\ValidationException;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast;

    public PollEditorForm $form;

    public $pollIndex;

    public $poll;

    public $timezones;

    public $listeners = ['newDate' => 'addNewDate'];

    public function mount(PollQueryService $pollQueryService, $pollIndex = null): void
    {
        $this->pollIndex = $pollIndex;
        $this->poll = Poll::where('id', $pollIndex)->first();
        $this->form->loadForm($pollQueryService->getPollArray($this->pollIndex));
        $this->timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL); // Načtení všech časových pásem
    }

    // Odeslání formuláře
    public function submit(PollCreateService $pollCreateService)
    {

        if (! $this->canUpdate()) {
            $this->addError('error', __('pages/poll-editor.messages.error.dirty'));


            return null;
        }

        try {
            $validatedData = $this->form->prepareValidatedDataArray($this->form->validate());
            $poll = $pollCreateService->savePoll($validatedData, $this->pollIndex);

            return redirect()->route('polls.show', ['poll' => $poll->public_id]);
        } catch (ValidationException $e) {
            // Kontrola validace
            $this->dispatch('validation-failed', errors: $e->errors());
            $this->error(__('pages/poll-editor.messages.error.general'), position: 'toast-bottom toast-end');
            throw $e;
        } catch (PollException $e) {
            $this->addError('error', $e->getMessage());
            return null;
        } catch (Exception $e) {
            $this->addError('error', __('pages/poll-editor.messages.error.saving'));
            return null;
        }

    }

    // Kontrola, zda se anketa mezitím nezměnila
    private function canUpdate(): bool
    {
        if ($this->pollIndex) {
            $pollUpdated = Poll::find($this->pollIndex, ['updated_at']);
            if ($pollUpdated->updated_at !== $this->form->lastUpdated) {
                return false;
            }
        }

        return true;
    }


    public function addNewDate($date){
        dd('addNewDate');
    }
};
