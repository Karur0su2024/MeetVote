<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\PollService;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Form2 extends Component
{
    // Služby
    protected PollService $pollService;
    protected TimeOptionService $timeOptionService;

    public PollForm $form;


    public $poll;

    public $removedTimeOptions = [];
    public $removedQuestions = [];
    public $removedQuestionOptions = [];


    public function __construct()
    {
        $this->pollService = new PollService();
        $this->timeOptionService = new TimeOptionService();
    }

    public function mount($poll = null) : void
    {

        $this->form->loadForm($this->pollService->getPollData($poll));
    }


    public function submit(){

        try {
            $validatedData = $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }

        //přesunutí do jiné proměnné
        $validatedData['time_options'] = array_reduce($validatedData['dates'], function ($carry, $date) {
            return array_merge($carry, $date);
        }, []);

        unset($validatedData['dates']);

        $validatedData['removed'] = [
            'time_options' => $this->removedTimeOptions,
            'questions' => $this->removedQuestions,
            'question_options' => $this->removedQuestionOptions,
        ];


        //dd($validatedData);

        // Zkontrolovat duplicity
        // Zde zkontrolovat duplicity
        // Později
                //Uložit změny



        try {
            DB::beginTransaction();
            if($this->poll) {
                // Uložení změn ankety
                $this->poll = $this->pollService->updatePoll($this->poll, $validatedData);
            } else {
                // Vytvoření nové ankety
                $this->poll = $this->pollService->createPoll($validatedData);
            }


        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            // Zpracování chyby
            return;

        }

        //dd("test");

        DB::commit();
        session()->put('poll_' . $this->poll->public_id . '_adminKey', $this->poll->admin_key);
        return redirect()->route('polls.show', $this->poll);

    }


    // Blok funkcí pro data
    //
    //
    #[On('addDate')]
    public function addDate($date) : void
    {
        $this->resetErrorBag('form.dates');


        // Kontrola zda je datum již přidáno
        if(isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'This date has already been added.');
            return;
        }

        $isNotPast = Carbon::parse($date)->isFuture() || Carbon::parse($date)->isToday();

        if(!$isNotPast) {
            $this->addError('form.dates', 'You cannot add a date in the past.');
            return;
        }

        $this->addTimeOption($date, 'time');

        ksort($this->form->dates);

        //dd($this->form->dates);

        //dd($this->form->dates);
        return;

    }


    // Funkce pro odstranění data
    public function removeDate($date) : bool
    {
        //dd($this->form->dates);
        // Přidat komentář
        $this->resetErrorBag('form.dates');

        // Přidat komentář
        if(!isset($this->form->dates[$date])) {
            $this->addError('form.dates', 'The selected date does not exist.');
            return false;
        }

        // Přidat komentář
        if(count($this->form->dates) < 2) {
            $this->addError('form.dates', 'You must have at least one date.');
            return false;
        }

        //dd($this->form->dates[$date]);
        // Přidat komentář
        unset($this->form->dates[$date]);

        // Přidat komentář
        ksort($this->form->dates);

        return true;
    }
    //
    //
    // Funkce pro přidání časové možnosti
    //
    //
    public function addTimeOption($date, $type) : void
    {
        $this->resetErrorBag('form.dates');


        if(isset($this->form->timeOptions[$date])) {
            // přidat error
            return;
        }

        $this->form->dates[$date][] = $this->timeOptionService->addNewOption($date, $type, $this->getLastEnd($date));
        return;
    }

    public function removeTimeOption($date, $optionIndex) : void
    {
        $this->resetErrorBag('form.dates');

        //dd($this->form->dates[$date][$optionIndex]);
        if(!isset($this->form->dates[$date][$optionIndex])) {
            $this->addError('form.dates', 'This time option does not exist.');
            dd("tst");
            return;
        }


        if(count($this->form->dates[$date]) < 2) {
            if($this->removeDate($date)) {
                unset($this->form->dates[$date]);
            }
            else {
                $this->addError('form.dates', 'You must have at least one date.');
                return;
            }
        }


        // Zjistit, zda je možnost poslední





        // Pro existující ankety
        if(isset($this->form->dates[$date][$optionIndex]['id'])) {
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
    public function addQuestion() : void
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

    public function removeQuestion($questionIndex) : void
    {
        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->form->questions[$questionIndex])) {
            $question = &$this->questions[$questionIndex];
        } else {
            $this->addError('questions', 'The selected question does not exist.');
            return;
        }

        if(isset($question['id'])){
            $this->removedQuestions[] = $question['id'];
        }

        unset($this->form->questions[$questionIndex]);

        $this->form->questions = array_values($this->form->questions);

        return;

    }

    public function addQuestionOption($questionIndex) : void
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

    public function removeQuestionOption($questionIndex, $optionIndex) : void
    {
        $this->resetErrorBag('form.questions');

        if(isset($this->form->questions[$questionIndex]['options'][$optionIndex])) {
            $options = &$this->form->questions[$questionIndex]['options'];
        }
        else {
            $this->addError('form.questions', 'The selected option does not exist.');
            return;
        }

        if(count($options) <= 2) {
            $this->addError('form.questions', 'The question must have at least two options.');
            return;
        }

        if(isset($options[$optionIndex]['id'])) {
            $this->removedQuestionOptions[] = $options[$optionIndex]['id'];
        }

        unset($options[$optionIndex]);

        $options = array_values($options);

        return;
    }




    private function getLastEnd($date) : ?string
    {
        $endTime = null;

        if(isset($this->form->dates[$date])) {
            foreach($this->form->dates[$date] as $options) {
                if(isset($options['content']['end'])) {
                    $endTime = $options['content']['end'];
                }
            }
        }
        return $endTime;
    }




    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form2');
    }
}
