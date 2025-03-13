<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;

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

    public function boot(TimeOptionService $timeOptionService)
    {
        $this->timeOptionService = $timeOptionService;
    }

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();

        if (!$this->poll) {
            session()->flash('error', 'Poll not found.');
            return;
        }

        $this->type = 'time';
        $this->date = now()->format('Y-m-d');
    }

    public function changeType($type)
    {
        $this->type = $type;
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $timeOptions = $this->timeOptionService->getPollTimeOptions($this->poll);

        $timeOptions[] = [
            'date' => $validatedData['date'],
            'type' => $validatedData['type'],
            'content' => $validatedData['type'] === 'time' ? [
                'start' => $validatedData['content']['start'],
                'end' => $validatedData['content']['end'],
            ] : [
                'text' => $validatedData['content']['text'],
            ],
        ];

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



        $this->dispatch('updateTimeOptions');
        $this->dispatch('hideModal');
    }

    public function render()
    {
        return view('livewire.modals.poll.add-new-time-option');
    }
}
