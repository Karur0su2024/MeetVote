<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;
use App\Rules\CheckIfTimeOptionExists;

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
            'option' => ['required', 'array', new CheckIfTimeOptionExists($this->poll->id, $this->timeOptionService)],
            'option.type' => 'required|in:time,text',
            'option.date' => 'required|date',
            'option.content.start' => 'required_if:type,time|date_format:H:i',
            'option.content.end' => 'required_if:type,time|date_format:H:i|after:content.start',
            'option.content.text' => 'required_if:type,text|string',
        ];
    }


    protected TimeOptionService $timeOptionService;

    /**
     * @param TimeOptionService $timeOptionService
     * @return void
     */
    public function boot(TimeOptionService $timeOptionService)
    {
        $this->timeOptionService = $timeOptionService;
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
        $validatedData = $this->validate();

        try {
            $this->poll->timeOptions()->create([
                'date' => $validatedData['option']['date'],
                'start' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['start'] : null,
                'end' => $validatedData['option']['type'] === 'time' ? $validatedData['option']['content']['end'] : null,
                'text' => $validatedData['option']['type'] === 'text' ? $validatedData['option']['content']['text'] : null,
            ]);
        } catch (\Exception $e) {
            $this->addError('error', $e);
            return;
        }
        return redirect()->route('polls.show', $this->poll);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function render()
    {
        return view('livewire.modals.poll.add-new-time-option');
    }

}
