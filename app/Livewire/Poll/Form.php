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


class Form extends Component
{

    protected $pollService;

    // Název ankety
    #[Validate('required', 'string', 'min:3', 'max:255')]
    public $title = "abc";

    // Popis ankety
    #[Validate('nullable', 'max:1000')]
    public $description;

    // Deadline ankety, po kterém nebude možné hlasovat
    #[Validate('nullable', 'date')]
    public $deadline = null;

    // Nastavení ankety
    #[Validate([
        'settings' => 'array', // Komentáře
        'settings.comments' => 'boolean', // Komentáře
        'settings.anonymous' => 'boolean', // Anonymní hlasování
        'settings.hide_results' => 'boolean', // Skrytí výsledků
        'settings.password' => 'nullable|string', // Heslo
        'settings.invite_only' => 'boolean', // Pouze na pozvánku
    ])]
    public $settings = [
        'comments' => true,
        'anonymous' => false,
        'hide_results' => false,
        'password' => null,
        'invite_only' => false,
    ];


    // Časové možnosti
    #[Validate([
        'dates' => 'required|array|min:1', // Pole různých dnů
        'dates.*.date' => 'required|date', // Datum
        'dates.*.options' => 'required|array|min:1', // Časové možnosti podle data
        'dates.*.options.*.id' => 'nullable|integer', // ID možnosti
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.options.*.start' => 'required_if:options.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.options.*.end' => 'required_if:options.*.type,time|date_format:H:i|after:dates.*.options.*.start', // Konec časové možnosti
        'dates.*.options.*.text' => 'required_if:options.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];

    // Otázky
    #[Validate([
        'questions' => 'nullable|array', // Pole otázek
        'questions.*.id' => 'nullable|integer', // ID otázky
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.id' => 'nullable|integer', // ID možnosti
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti*/
    ])]
    public $questions = [];

    // Jméno uživatele
    #[Validate('required', 'string', 'min:3', 'max:255')]
    public $userName = "";

    // E-mail uživatele
    #[Validate('required', 'email')]
    public $userEmail = "";


    // Načtení dat ankety
    use PollData;

    // Načtení možností ankety
    use Options;

    public $poll;

    // Metoda mount
    function mount(PollService $pollService, $poll = null)
    {
        $this->pollService = $pollService;

        $this->poll = $poll;

        if ($this->poll) {
            $this->loadExistingPoll();
        } else {
            $this->loadNewPoll();
        }
    }


    private function loadNewPoll()
    {
        // Pokud je uživatel přihlášený, načtou se jeho údaje
        if (Auth::check()) {
            $this->userName = Auth::user()->name;
            $this->userEmail = Auth::user()->email;
        }

        // Přidání prvního data
        $this->addDate(date('Y-m-d'));
    }

    private function loadExistingPoll()
    {
        // Načtení dat ankety
        //$data = $this->pollService->getPollData($this->poll);


        $this->userName = $data['user_name'];
        $this->userEmail = $data['user_email'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->deadline = $data['deadline'];
        $this->settings = $data['settings'];


        // Načtení časových možností
        $this->loadTimeOptions();

        // Načtení otázek
        $this->loadQuestions();
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
    public function loadQuestions()
    {
        $questions = $this->poll->questions;

        foreach ($questions as $question) {
            //dd($question);
            $questionOptions = [];
            foreach ($question->options as $option) {
                $questionOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['text'],
                ];
            }

            $this->questions[] = [
                'id' => $question['id'],
                'text' => $question['text'],
                'options' => $questionOptions,
            ];
        }
    }


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


    // Metoda pro načtení časových možností
    public function loadTimeOptions()
    {
        $dates = $this->poll->timeOptions->groupBy('date')->toArray();

        foreach ($dates as $dateIndex => $options) {
            $timeOptions = [];
            foreach ($options as $option) {
                if ($option['start'] != null) {
                    $timeOptions[] = [
                        'id' => $option['id'],
                        'type' => 'time',
                        'start' => Carbon::parse($option['start'])->format('H:i'),
                        'end' => Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i'),
                    ];
                } else {
                    $timeOptions[] = [
                        'id' => $option['id'],
                        'type' => 'text',
                        'text' => $option['text'],
                    ];
                }
            }

            $this->dates[$dateIndex] = [
                'date' => $dateIndex,
                'options' => $timeOptions,
            ];
        }
        //dd($this->dates);

    }




    // Metoda pro přidání nového data z kalendáře
    #[On('addDate')]
    public function addDate($date): bool
    {
        $this->resetErrorBag('dates');

        // Kontrola, zda datum již neexistuje
        if (isset($this->dates[$date])) {
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
        $this->dates[$date] = [
            'date' => $date,
            'options' => [],
        ];

        $this->addDateOption($date, 'time');


        // Seřazení dat podle klíče
        ksort($this->dates);

        return true;
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

    // Metoda pro přidání nové časové možnosti
    private function addNewTimeOption($date): bool
    {

        $date_options = &$this->dates[$date]['options'];
        $start_time = Carbon::now()->format('H:i');

        // Získání posledního konce
        foreach ($date_options as $option) {
            if ($option['type'] === 'time') {
                $start_time = Carbon::parse($option['end'])->format('H:i');
            }
        }

        // Nastavení konce hodinu po začátku
        $end_time = Carbon::parse($start_time)->addHour()->format('H:i');

        // přidání nové časové možnosti do pole
        $date_options[] = ['type' => 'time', 'start' => $start_time, 'end' => $end_time];

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

        foreach ($dates as $date) {
            $optionContent = [];

            // Načtení všech možností v textové podobě podobě
            foreach ($date['options'] as $option) {
                $optionContent[] = $this->convertTimeOptionToText($option);
            }

            // Porovnání všech termínů a unikátních termínů
            if (count($optionContent) !== count(array_unique($optionContent))) {
                $this->addError('save', 'Duplicate time options are not allowed.');
                return false;
            }
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


    // Metoda pro konverzi časové možnosti na textovou podobu
    private function convertTimeOptionToText($option)
    {
        if ($option['type'] == 'time') {
            return strtolower($option['start'] . '-' . $option['end']);
        } else {
            return strtolower($option['text'] . '-text');
        }
    }


    public function render()
    {
        return view('livewire.poll.form');
    }
}
