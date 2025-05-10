<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use Livewire\Component;
use App\Rules\CheckIfTimeOptionExists;
use Illuminate\Support\Facades\Gate;

// Modální okno pro přidání nové časové možnosti na stránce ankety
class AddNewTime extends Component
{
    public $poll;
    public $option = [
        'type' => 'time',
        'date' => '',
        'content' => ['start' => '', 'end' => '', 'text' => ''],
    ];

    public function rules(): array
    {
        return [
            'option' => ['required', 'array', new CheckIfTimeOptionExists($this->poll->id)],
            'option.type' => 'required|in:time,text',
            'option.date' => 'required|date|after_or_equal:today',
            'option.content.start' => 'required_if:type,time|date_format:H:i',
            'option.content.end' => 'required_if:type,time|date_format:H:i|after:option.content.start',
            'option.content.text' => 'required_if:type,text|string',
        ];
    }

    public function mount($pollIndex)
    {
        $this->poll = Poll::find($pollIndex);
        $this->option['date'] = now()->format('Y-m-d');
    }

    public function submit()
    {
        if (Gate::denies('addNewOption', $this->poll)) {
            $this->addError('error', __('ui/modals.add_new_time_option.messages.error.no_permissions'));
            return null;
        }

        try {
            $this->saveOption($this->validate());
            return redirect()->route('polls.show', $this->poll);
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
            return null;
        }
    }


    private function saveOption($validatedData)
    {
        $this->poll->timeOptions()->create([
            'date' => $validatedData['option']['date'],
            'start' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['start'] : null,
            'end' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['end'] : null,
            'text' => $validatedData['option']['type'] === 'text' ? $validatedData['option']['content']['text'] : null,
        ]);
    }

    public function render()
    {
        return view('livewire.modals.poll.add-new-time');
    }
}
