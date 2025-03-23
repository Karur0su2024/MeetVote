<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;

/**
 *
 */
class AddNewTimeOption extends Component
{
    public $poll;

    public $type;

    public $date;

    public $content = [
        'start' => '',
        'end' => '',
        'text' => '',
    ];

    protected $rules = [
        'type' => 'required|in:time,text',
        'date' => 'required|date',
        'content.start' => 'required_if:type,time|date_format:H:i',
        'content.end' => 'required_if:type,time|date_format:H:i|after:content.start',
        'content.text' => 'required_if:type,text|string',
    ];

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
        $this->type = 'time';
        $this->date = now()->format('Y-m-d');
    }

    /**
     * Metoda pro změnu typu časové možnosti.
     * @param $type
     * @return void
     */
    public function changeType($type)
    {
        $this->type = $type;
    }

    /**
     * Metoda pro zpracování události odeslání formuláře.
     * @return void
     */
    public function submit()
    {
        $validatedData = $this->validate();

        $content = $this->type === 'time' ?
            [
                'start' => $validatedData['content']['start'],
                'end' => $validatedData['content']['end'],
            ] : [
                'text' => $validatedData['content']['text'],
            ];

        $timeOptions[] = [
            'date' => $validatedData['date'],
            'type' => $validatedData['type'],
            'content' => $content,
        ];

        $timeOptions = $this->timeOptionService->getPollTimeOptions($this->poll);


        if ($this->timeOptionService->checkDuplicity($timeOptions)) {
            $this->addError('error', 'Duplicity detected');
            return;
        }

        try {

            $this->poll->timeOptions()->create([
                'date' => $validatedData['date'],
                'start' => $validatedData['type'] === 'time' ? $validatedData['content']['start'] : null,
                'text' => $validatedData['type'] === 'text' ? $validatedData['content']['text'] : null,
                'minutes' => $validatedData['type'] === 'time' ? Carbon::parse($validatedData['content']['start'])->diffInMinutes(Carbon::parse($validatedData['content']['end'])) : null,
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating time option.');
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
