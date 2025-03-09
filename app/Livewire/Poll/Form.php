<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Services\QuestionService;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\PollService;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Poll;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    // Služby
    protected ?PollService $pollService;
    protected ?TimeOptionService $timeOptionService;
    protected ?QuestionService $questionService;

    public PollForm $form;


    public ?Poll $poll;

    public $removedTimeOptions = [];
    public $removedQuestions = [];
    public $removedQuestionOptions = [];


    public function __construct()
    {
        $this->pollService = app(PollService::class);
        $this->timeOptionService = app(TimeOptionService::class);
        $this->questionService = app(QuestionService::class);
    }

    // Konstruktor
    public function mount(?Poll $poll): void
    {
        // Načtení dat ankety
        $this->poll = $poll;

        $this->form->loadForm($this->pollService->getPollData($poll));

    }


    // Metoda po odelání formuláře
    public function submit()
    {
        // Validace
        try {
            $validatedData = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error($e->errors());
            session()->flash('error', 'Validation failed. Please check your input.');
            return;
        }

        $validatedData = $this->prepareValidatedDataArray($validatedData);


        if ($this->checkDuplicity($validatedData)) {
            return;
        }

        $this->savePoll($validatedData);

    }



    // Metoda pro transakci a uložení ankety
    private function savePoll($validatedData){
        try {
            DB::beginTransaction();


            if (Poll::find($this->poll->id)) {
                // Uložení změn ankety
                $this->poll = $this->pollService->updatePoll($this->poll, $validatedData);
            } else {

                $this->poll = $this->pollService->createPoll($validatedData);
            }
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            // Zpracování chyby
            return;
        }

        DB::commit();
        session()->put('poll_' . $this->poll->public_id . '_adminKey', $this->poll->admin_key);
        return redirect()->route('polls.show', $this->poll);
    }


    // Úprava pole pro uložení do databáze
    private function prepareValidatedDataArray($validatedData) : array
    {

        // Převod z dat do formátu pro uložení do databáze
        $validatedData['time_options'] = array_reduce($validatedData['dates'], function ($carry, $date) {
            return array_merge($carry, $date);
        }, []);

        unset($validatedData['dates']);

        $validatedData['removed'] = [
            'time_options' => $this->removedTimeOptions,
            'questions' => $this->removedQuestions,
            'question_options' => $this->removedQuestionOptions,
        ];

        return $validatedData;
    }


    // Kontrola duplicitních otázek a časových možností
    private function checkDuplicity($validatedData)
    {
        if ($this->timeOptionService->checkDuplicity($validatedData['time_options'])) {
            $this->addError('form.dates', 'Duplicate time options are not allowed.');
            return true;
        }

        if ($this->questionService->checkDupliciteQuestions($validatedData['questions'])) {
            $this->addError('form.questions', 'Duplicate questions are not allowed.');
            return true;
        }

        //Dodělat kontrolu duplicitních otázek
        return false;
    }


    // Funkce pro přidání data
    // Volá se po výběru dne v kalendáři
    #[On('addDate')]
    public function addDate($date): void
    {
        $this->resetErrorBag('form.dates');


        // Kontrola zda je datum již přidáno
        if (isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'This date has already been added.');
            return;
        }

        $isNotPast = Carbon::parse($date)->isFuture() || Carbon::parse($date)->isToday();

        if (!$isNotPast) {
            $this->addError('form.dates', 'You cannot add a date in the past.');
            return;
        }

        $this->form->dates[$date] = [];

        $this->addTimeOption($date, 'time');

        ksort($this->form->dates);

        //dd($this->form->dates);

        //dd($this->form->dates);
        return;
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


        foreach($this->form->dates[$date] as $optionIndex => $option) {
            if(isset($option['id'])) {
                $this->removedTimeOptions[] = $option['id'];
            }
        }


        unset($this->form->dates[$date]);
        ksort($this->form->dates);

        return true;
    }
    //
    //
    // Funkce pro přidání časové možnosti
    //
    //
    public function addTimeOption($date, $type): void
    {
        $this->resetErrorBag('form.dates');


        if (isset($this->form->timeOptions[$date])) {
            // přidat error
            return;
        }


        $this->form->dates[$date][] = $this->timeOptionService->addNewOption($date, $type, $this->timeOptionService->getLastEnd($this->form->dates[$date]));

        ksort($this->form->dates);
        return;
    }

    public function removeTimeOption($date, $optionIndex): void
    {
        $this->resetErrorBag('form.dates');

        if (!isset($this->form->dates[$date][$optionIndex])) {
            $this->addError('form.dates', 'This time option does not exist.');
            return;
        }

        // Pokud je poslední časová možnost, nelze ji odstranit
        if (count($this->form->dates[$date]) < 2) {
            // Pokud je poslední datum, nelze jej odstranit
            if (count($this->form->dates) < 2) {
                $this->addError('form.dates', 'You must have at least one date.');
                return;
            }


            // Pro existující ankety
            if (isset($this->form->dates[$date][$optionIndex]['id'])) {
                $this->removedTimeOptions[] = $this->form->dates[$date][$optionIndex]['id'];
            }


            if ($this->removeDate($date)) {
                unset($this->form->dates[$date]);
            }

            ksort($this->form->dates);
            return;
        }



        // Pro existující ankety
        if (isset($this->form->dates[$date][$optionIndex]['id'])) {
            $this->removedTimeOptions[] = $this->form->dates[$date][$optionIndex]['id'];
        }



        unset($this->form->dates[$date][$optionIndex]);

        $this->form->dates[$date] = array_values($this->form->dates[$date]);

        return;
    }
    //
    //
    // Funkce pro přidání otázky
    //
    //
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

                ]
            ],
        ];

        return;
    }

    public function removeQuestion($questionIndex): void
    {
        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->form->questions[$questionIndex])) {
            $question = &$this->form->questions[$questionIndex];
        } else {
            $this->addError('questions', 'The selected question does not exist.');
            return;
        }

        if (isset($question['id'])) {
            $this->removedQuestions[] = $question['id'];
        }

        unset($this->form->questions[$questionIndex]);

        $this->form->questions = array_values($this->form->questions);

        return;
    }

    public function addQuestionOption($questionIndex): void
    {
        $this->resetErrorBag('questions');

        // Kontrola, zda otázka existuje
        if (!isset($this->form->questions[$questionIndex])) {
            $this->addError('questions', 'The selected option does not exist.');
            return;
        }

        // Přidání nové možnosti
        $this->form->questions[$questionIndex]['options'][] = ['text' => ''];

        return;
    }

    public function removeQuestionOption($questionIndex, $optionIndex): void
    {
        $this->resetErrorBag('form.questions');

        if (isset($this->form->questions[$questionIndex]['options'][$optionIndex])) {
            $options = &$this->form->questions[$questionIndex]['options'];
        } else {
            $this->addError('form.questions', 'The selected option does not exist.');
            return;
        }

        if (count($options) <= 2) {
            $this->addError('form.questions', 'The question must have at least two options.');
            return;
        }

        if (isset($options[$optionIndex]['id'])) {
            $this->removedQuestionOptions[] = $options[$optionIndex]['id'];
        }

        unset($options[$optionIndex]);

        $options = array_values($options);

        return;
    }




    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form');
    }
}
