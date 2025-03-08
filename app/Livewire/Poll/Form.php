<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;

use App\Models\TimeOption;


use App\Traits\PollForm\Options;
use App\Traits\PollForm\PollData;

use App\Services\PollService;
use App\Services\TimeOptionService;

use App\Livewire\Forms\PollForm;



class Form extends Component
{
    protected $pollService;
    protected $timeOptionService;

    // Data formuláře
    public PollForm $form;

    public $poll;

    // Metoda mount
    public function mount($poll = null)
    {
        $this->initializeServices();
        $this->form->loadForm($this->pollService->getPollData($poll));
    }

    private function initializeServices()
    {
        // Inicializace služeb
        $this->pollService = new PollService();
        $this->timeOptionService = new TimeOptionService();
    }




    // Metoda pro přidání nového data z kalendáře
    #[On('addDate')]
    public function addDate($date): bool
    {
        // resetování chybového pole
        $this->resetErrorBag('dates');

        // Kontrola, zda datum již neexistuje
        if (isset($this->form->dates[$date])) {
            $this->addError('dates', 'This date has already been added.');
            return false;
        }

        // Kontrola, zda datum není v minulosti
        $is_not_past = Carbon::parse($date)->isToday() || Carbon::parse($date)->isFuture();

        // Pokud je datum v minulosti, nelze ho přidat
        if (!$is_not_past) {
            $this->addError('dates', 'You cannot add a date in the past.');
            return false;
        }

        // Přidání nového data
        $this->form->dates[$date] = [
            'date' => $date,
        ];

        //$this->addDateOption($date, 'time');


        // Seřazení dat podle klíče
        ksort($this->form->dates);

        return true;
    }


    // Odeslání formuláře
    public function submit()
    {
        // Validace
        $validatedData = $this->validate();

        // Kontrola duplicit
        if (!$this->checkDuplicate($validatedData)) {
            return;
        }

        // Uložení změn ankety
        if ($poll = $this->save($validatedData)) {


            // Uložení klíče správce ankety do session
            session()->put('poll_' . $poll->public_id . '_adminKey', $poll->admin_key);

            return redirect()->route('polls.show', $poll);
        } else {
            return;
        }
    }



    private function save($validatedData): ?Poll
    {

        // Započetí transakce, pokud se něco nepovede, vrátí se zpět
        DB::beginTransaction();

        try {
            if ($poll = $this->poll) {

                // Uložení změn ankety
                $this->pollService->updatePoll($this->poll, $validatedData);

                // Odstranění existujících možností
                $this->removeDeletedOptions();


                // Uložení časových možností a otázek
                $this->saveOptions($this->poll, $validatedData);
            } else {

                // Vytvoření nové ankety
                $poll = $this->pollService->createPoll($validatedData);

                // Uložení časových možností a otázek
                $this->saveOptions($poll, $validatedData);
            }

            DB::commit();

            return $poll;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return null;
        }
    }


    // Načtení otázek



    // Metoda pro přidání otázky
    public function addQuestion()
    {
        // Přidání nové otázky s dvěma možnostmi
        $this->questions[] = [
            'text' => '',
            'options' => [
                [
                    'text' => '',
                ],
                [
                    'text' => '',
                ],
            ]
        ];
    }

    // Metoda pro odstranění otázky
    public function removeQuestion($index): bool
    {
        $this->resetErrorBag('questions');

        // Pokud otázka neexistuje, nelze ji odstranit
        if (isset($this->questions[$index])) {
            $question = &$this->questions[$index];
        } else {
            $this->addError('questions', 'The selected question does not exist.');
            return false;
        }

        // Pokud otázka má ID, uloží se do pole pro odstranění
        if (isset($question['id'])) {
            $this->removedQuestions[] = $question['id'];
        }

        // Odstranění otázky
        unset($this->questions[$index]);

        $this->questions = array_values($this->questions);

        $this->resetErrorBag('questions');
        return true;
    }

    // Metoda pro přidání možnosti k otázce
    public function addQuestionOption($questionIndex): bool
    {
        $this->resetErrorBag('questions');

        // Kontrola, zda otázka existuje
        if (!isset($this->questions[$questionIndex])) {
            $this->addError('questions', 'The selected option does not exist.');
            return false;
        }

        // Přidání nové možnosti
        $this->questions[$questionIndex]['options'][] = ['text' => ''];

        return true;
    }



    // Metoda pro odstranění možnosti k otázce
    public function removeQuestionOption($questionIndex, $optionIndex): bool
    {
        $this->resetErrorBag('questions');

        // Kontrola, zda otázka a možnost existuje
        if (isset($this->questions[$questionIndex]['options'][$optionIndex])) {
            $question_options = &$this->questions[$questionIndex]['options'];
        } else {
            $this->addError('questions', 'The selected question does not exist.');
            return false;
        }

        // Pokud je má otázka pouze dvě možnosti, nelze je smazat
        if (count($question_options) <= 2) {
            $this->addError('questions', 'The question must have at least two options.');
            return false;
        }

        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if (isset($question_options[$optionIndex]['id'])) {
            $this->removedQuestionOptions[] = $question_options[$optionIndex]['id'];
        }

        // Odstranění možnosti
        unset($question_options[$optionIndex]);

        // Přeindexování možností
        $question_options = array_values($question_options);

        return true;
    }


    // Tohle přesunout do služby
    public function checkDupliciteQuestions($validatedData): bool
    {

        $this->resetErrorBag('save');

        // Kontrola duplicitních otázek
        $questions = array_map('mb_strtolower', array_column($validatedData['questions'], 'text'));

        // Porovnání všech textů otázek a unikátních textů otázek
        if (count($questions) !== count(array_unique($questions))) {
            $this->addError('save', 'Duplicate questions are not allowed.');
            return false;
        }

        // Kontrola možností
        foreach ($validatedData['questions'] as $question) {
            $options = array_map('mb_strtolower', array_column($question['options'], 'text'));
            if (count($options) !== count(array_unique($options))) {
                $this->addError('save', 'Duplicate options in a question are not allowed.');
                return false;
            }
        }

        return true;
    }



    // Tohlento přesunout do služby
    // Metoda pro uložení otázek
    private function saveQuestions($poll, $questions)
    {
        // Přidání otázek
        foreach ($questions as $question) {
            if (isset($question['id'])) {
                // Aktualizace otázky, která již existuje
                $newQuestion = PollQuestion::find($question['id']);

                if (!$newQuestion) {
                    $this->addError('save', 'Failed to update: Question not found.');
                    return;
                }

                $newQuestion->update([
                    'text' => $question['text'],
                ]);
            } else {
                // Přidání nové otázky do databáze
                $newQuestion = $poll->questions()->create([
                    'text' => $question['text'],
                ]);
            }
            foreach ($question['options'] as $option) {
                $this->saveQuestionOption($newQuestion, $option);
            }
        }
    }


    // Tohle přesunout do služby
    // Metoda pro uložení možností otázek
    private function saveQuestionOption($question, $option)
    {
        if (isset($option['id'])) {
            // Aktualizace možnosti, která již existuje
            $newOption = QuestionOption::find($option['id']);
            if (!$newOption) {
                $this->addError('save', 'Failed to update: Option not found.');
                return;
            }
            $newOption->update([
                'text' => $option['text'],
            ]);
        } else {
            // Přidání nové možnosti do databáze
            $question->options()->create([
                'text' => $option['text'],
            ]);
        }
    }









    // Metoda pro odstranění data
    public function removeDate($date): bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date])) {
            $this->addError('dates', 'The selected date does not exist.');
            return false;
        }

        // Pokud je pouze jedno datum, nelze ho odstranit
        if (count($this->dates) == 1) {
            $this->addError('dates', 'At least one date must remain.');
            return false;
        }

        // Odstranění data
        unset($this->dates[$date]);

        // Seřazení dat podle klíče
        ksort($this->dates);


        return true;
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($date, $type): bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date]['options'])) {

            $this->addError('dates', 'The selected date does not exist.');
            return false;
        }

        // Kontrola, zda je typ možnosti časový nebo textový
        if ($type == 'time') {
            $this->addNewTimeOption($date);
        } else {
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
        }

        return true;
    }


    // Metoda pro odstranění časových možnosti
    public function removeDateOption($dateIndex, $optionIndex): bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum a možnost existuje
        if (isset($this->dates[$dateIndex]['options'][$optionIndex])) {
            $date_options = &$this->dates[$dateIndex]['options'];
        } else {
            $this->resetErrorBag('dates');
            $this->addError('dates', 'The selected time option does not exist.');
            return false;
        }

        // Pokud je pouze jedna možnost, nelze ji odstranit
        if (count($date_options) == 1) {
            if (!$this->removeDate($dateIndex)) {
                $this->addError('dates', 'At least one time option must remain.');
                return false;
            }
        }


        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if (isset($date_options[$optionIndex]['id'])) {

            $this->removedTimeOptions[] = $date_options[$optionIndex]['id'];
        }

        // Odstranění možnosti z pole
        unset($date_options[$optionIndex]);

        // Přeindexování možností
        $date_options = array_values($date_options);

        return true;
    }



    // Metoda pro zjištění, zda nejde o duplicitní časové možnosti
    private function checkDupliciteTimeOptions($dates): bool
    {
        $this->resetErrorBag('save');

        $error = $this->timeOptionService->checkDupliciteTimeOptions($dates);

        if($error){
            $this->addError('save', $error);
            return false;
        }

        return true;
    }


    // Metoda pro uložení časových možností
    private function saveTimeOptions($poll, $dates): bool
    {
        $this->resetErrorBag('save');
        foreach ($dates as $date) {
            foreach ($date['options'] as $option) {
                if ($option['type'] == 'time') {
                    $minutes = Carbon::parse($option['start'])->diffInMinutes($option['end']);
                    //dd($option);

                    if (isset($option['id'])) {
                        // Aktualizace časové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        if (!$newOption) {
                            $this->addError('save', 'Failed to update: Time option not found.');
                            return false;
                        }
                        $newOption->update([
                            'start' => $date['date'] . ' ' . $option['start'],
                            'minutes' => $minutes
                        ]);
                    } else {
                        //dd($option);
                        // Přidání nové časové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'start' => $option['start'],
                            'minutes' => $minutes
                        ]);
                    }
                } else {

                    if (isset($option['id'])) {
                        // Aktualizace textové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        if (!$newOption) {
                            $this->addError('save', 'Failed to update: Time option not found.');
                            return false;
                        }
                        $newOption->update([
                            'text' => $option['text'],
                        ]);
                    } else {
                        // Přidání textové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'text' => $option['text'],
                        ]);
                    }
                }
            }
        }

        return true;
    }




    public function render()
    {
        return view('livewire.poll.form');
    }
}
