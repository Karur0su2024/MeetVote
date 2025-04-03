<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Services\TimeOptions\TimeOptionQueryService;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;
use App\Rules\CheckIfTimeOptionExists;
use Illuminate\Support\Facades\Gate;

/**
 *
 */
class AddNewTimeOption extends Component
{
    public $poll;

    public $option = [
        'type' => 'time',
        'date' => '',
        'content' => [
            'start' => '',
            'end' => '',
            'text' => '',
        ],
    ];

    public function rules(): array
    {
        return [
            'option' => ['required', 'array', new CheckIfTimeOptionExists($this->poll->id)],
            'option.type' => 'required|in:time,text',
            'option.date' => 'required|date|after_or_equal:today',
            'option.content.start' => 'required_if:type,time|date_format:H:i',
            'option.content.end' => 'required_if:type,time|date_format:H:i|after:content.start',
            'option.content.text' => 'required_if:type,text|string',
        ];
    }

    /**
     * @param $pollIndex
     * @return void
     */
    public function mount($pollIndex)
    {
        $this->poll = Poll::find($pollIndex);
        $this->option['type'] = 'time';
        $this->option['date'] = now()->format('Y-m-d');
    }

    /**
     * Metoda pro změnu typu časové možnosti.
     * @param $type
     * @return void
     */
    public function changeType($type)
    {
        $this->poll['type'] = $type;
    }

    /**
     * Metoda pro zpracování události odeslání formuláře.
     * @return void
     */
    public function submit()
    {
        if(!Gate::allows('addOption', $this->poll)){
            $this->addError('error', __('ui/modals.add_new_time_option.messages.error.no_permissions'));
            return;
        }

        $validatedData = $this->validate();

        try {
            $this->poll->timeOptions()->create([
                'date' => $validatedData['option']['date'],
                'start' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['start'] : null,
                'end' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['end'] : null,
                'text' => $validatedData['option']['type'] === 'text' ? $validatedData['option']['content']['text'] : null,
            ]);
            return redirect()->route('polls.show', $this->poll);
        } catch (\Exception $e) {
            $this->addError('error', $e);
            return;
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.modals.poll.add-new-time-option');
    }

}
