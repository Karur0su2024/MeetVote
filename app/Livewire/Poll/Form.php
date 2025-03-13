<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public ?PollForm $form;

    public ?Poll $poll;

    // Služby
    protected PollService $pollService;

    public function boot(PollService $pollService) {
        $this->pollService = $pollService;
    }

    // Konstruktor
    public function mount(?Poll $poll)
    {
        // Načtení dat ankety
        $this->poll = $poll;
        $this->form->loadForm($this->pollService->getPollData($poll));
    }

    public function submit()
    {
        $poll = $this->form->submit($this->pollService);

        if ($poll) {
            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return redirect()->route('polls.show', $poll);
        }

    }

    // Funkce pro přidání data
    // Volá se po výběru dne v kalendáři
    #[On('addDate')]
    public function addDate($date): void
    {
        $this->resetErrorBag('form.dates');

        dd($date);

        $date = Carbon::parse($date)->format('Y-m-d');


        // Kontrola zda je datum již přidáno
        if (isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'This date has already been added.');

            return;
        }

        $isNotPast = Carbon::parse($date)->isFuture() || Carbon::parse($date)->isToday();

        if (! $isNotPast) {
            $this->addError('form.dates', 'You cannot add a date in the past.');
            return;
        }

        $this->form->dates[$date] = [];

        $this->addTimeOption($date, 'time');

        ksort($this->form->dates);

    }

    // Funkce pro odstranění data
    // V případě, že je poslední časová možnost, nelze ji odstranit
    // Odstraní také všechny časové možnosti uvnitř data
    public function removeDate($date): bool
    {
        $this->resetErrorBag('form.dates');

        if (!isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'The selected date does not exist.');
            return false;
        }

        if (count($this->form->dates) < 2) {
            $this->addError('form.dates', 'You must have at least one date.');
            return false;
        }

        foreach ($this->form->dates[$date] as $optionIndex => $option) {
            if (isset($option['id'])) {
                $this->form->removed['time_options'][] = $option['id'];
            }
        }

        unset($this->form->dates[$date]);
        ksort($this->form->dates);

        return true;
    }

    // Funkce pro přidání časové možnosti
    // Vkládá se datum a typ časové možnosti
    // Typ může být 'time' nebo 'text'
    public function addTimeOption($date, $type): void
    {
        $this->resetErrorBag('form.dates');

        if (isset($this->form->timeOptions[$date])) {
            // přidat error
            return;
        }

        $this->form->dates[$date][] = $this->pollService->getTimeOptionService()->addNewOption($date, $type, $this->pollService->getTimeOptionService()->getLastEnd($this->form->dates[$date]));

        ksort($this->form->dates);
    }

    // Funkce pro odstranění časové možnosti
    // Vkládá se datum a index odstraněné možnosti
    public function removeTimeOption($date, $optionIndex): void
    {
        $this->resetErrorBag('form.dates');

        if (! isset($this->form->dates[$date][$optionIndex])) {
            $this->addError('form.dates', 'This time option does not exist.');
            return;
        }

        $removedOptionId = $this->form->dates[$date][$optionIndex]['id'] ?? null;

        // Pokud je poslední časová možnost
        if (count($this->form->dates[$date]) === 1) {
            // Pokud je poslední datum, nelze jej odstranit
            if (count($this->form->dates) === 1) {
                $this->addError('form.dates', 'You must have at least one date.');
                return;
            }

            if(!$this->removeDate($date)) {
                return;
            }
        }
        else {
            unset($this->form->dates[$date][$optionIndex]);
            $this->form->dates[$date] = array_values($this->form->dates[$date]);
        }

        // Pokud měla možnost záznam v databázi, přidat ji do pole odstraněných
        if (isset($removedOptionId)) {
            $this->form->removed['time_options'][] = $removedOptionId;
        }
    }

    // Funkce pro přidání otázky
    public function addQuestion(): void
    {
        $this->form->questions[] = [
            'text' => '',
            'options' => [
                [
                    'text' => '',
                ],
                [
                    'text' => '',

                ],
            ],
        ];
    }

    // Funkce pro odstranění otázky
    // Vkládá se index otázky
    public function removeQuestion($questionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->form->questions[$questionIndex])) {
            $question = &$this->form->questions[$questionIndex];
        } else {
            $this->addError('form.questions', 'The selected question does not exist.');

            return;
        }

        // Pokud se jedná o existující otázku, přidat ji do pole odstraněných otázek
        if (isset($question['id'])) {
            $this->form->removed['questions'][] = $question['id'];
        }

        // Odstranění otázky z pole
        unset($this->form->questions[$questionIndex]);

        // Posunout indexy otázek
        $this->form->questions = array_values($this->form->questions);
    }

    // Funkce pro přidání možnosti otázky
    // Vkládá se index otázky
    public function addQuestionOption($questionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Kontrola, zda otázka existuje
        if (! isset($this->form->questions[$questionIndex])) {
            $this->addError('form.questions', 'The selected question not exist.');

            return;
        }

        // Přidání nové možnosti do pole otázky
        $this->form->questions[$questionIndex]['options'][] = ['text' => ''];
    }

    // Funkce pro odstranění možnosti otázky
    // Vkládá se index otázky a index odstraněné možnosti
    public function removeQuestionOption($questionIndex, $optionIndex): void
    {
        // Resetování stavu chyby
        $this->resetErrorBag('form.questions');

        // Kontrola, zda otázka existuje
        if (isset($this->form->questions[$questionIndex]['options'][$optionIndex])) {
            $options = &$this->form->questions[$questionIndex]['options'];
        } else {
            $this->addError('form.questions', 'The selected option does not exist.');

            return;
        }

        // Otázka musí mít alespoň dvě možnosti
        if (count($options) <= 2) {
            $this->addError('form.questions', 'The question must have at least two options.');

            return;
        }

        // V případě, že možnost existuje, přidat ji do pole odstraněných
        if (isset($options[$optionIndex]['id'])) {
            $this->form->removed['question_options'][] = $options[$optionIndex]['id'];
        }

        unset($options[$optionIndex]);

        $options = array_values($options);
    }

    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form');
    }
}
