<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\DB;
use App\Livewire\Forms\Poll\CreateForm;
use Carbon\Carbon;

class FormCreate extends Component
{

    public $poll;
    public CreateForm $createForm;

    // Název ankety
    #[Validate('required', 'string', 'min:3', 'max:255')]
    public $title = "abc";

    // Popis ankety
    #[Validate('nullable', 'max:1000')]
    public $description;

    // Jméno uživatele
    #[Validate('required', 'string', 'min:3', 'max:255')]
    public $userName;

    // E-mail uživatele
    #[Validate('required', 'email')]
    public $userEmail;

    // Deadline ankety, po kterém nebude možné hlasovat
    #[Validate('nullable', 'date')]
    public $deadline = null;

    // Nastavení ankety
    #[Validate([
        'settings' => 'array', // Komentáře
        'settings.comments' => 'boolean', // Komentáře
        'settings.anonymous' => 'boolean', // Anonymní hlasování
        'settings.hide_results' => 'boolean', // Skrytí výsledků
        'settings.password' => 'nullable|string|min:3', // Heslo
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
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.options.*.start' => 'required_if:options.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.options.*.end' => 'required_if:options.*.type,time|date_format:H:i|after:options.*.start', // Konec časové možnosti
        'dates.*.options.*.text' => 'required_if:options.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];

    // Otázky
    #[Validate([
        'questions' => 'nullable|array', // Pole otázek
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti*/
    ])]
    public $questions = [];


    // Metoda mount
    function mount()
    {
        // Pokud je uživatel přihlášený, načtou se jeho údaje
        if (Auth::check()) {
            $this->userName = Auth::user()->name;
            $this->userEmail = Auth::user()->email;
        }

        // Přidání prvního data
        $this->addDate(date('Y-m-d'));
    }

    // Metoda pro přidání nového data
    #[On('addDate')]
    public function addDate($date)
    {
        // Kontrola, zda je datum vyplněné
        if (!isset($date)) return;

        // Kontrola, zda datum již neexistuje
        if (isset($this->dates[$date])) return;

        // Přidání nového data
        $this->dates[$date] = [
            'date' => $date,
            'options' => [],
        ];

        $this->addDateOption($date, 'time');

        // Seřazení dat podle klíče
        ksort($this->dates);
    }

    // Metoda pro odstranění data
    public function removeDate($date)
    {
        // Pokud je pouze jedno datum, nelze ho odstranit
        if (count($this->dates) == 1) return;

        // Odstranění data
        unset($this->dates[$date]);

        // Seřazení dat podle klíče
        ksort($this->dates);
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($date, $type)
    {
        // Kontrola, zda datum existuje
        if (!isset($this->dates[$date])) return;

        //dd($dateIndex);
        if ($type == 'time'){
            $this->addNewTimeOption($date);

        }
        else {
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
        }
        
    }

    private function addNewTimeOption($date){
        $start = Carbon::now()->format('H:i');


        // Získání posledního konce
        foreach($this->dates[$date]['options'] as $option){
            if($option['type'] == 'time'){
                $lastEnd = Carbon::parse($option['end'])->format('H:i');
            }
        }


        // Počet možností
        $optionCount = count($this->dates[$date]['options']);

        // Pokud je více možností, začátek se nastaví na konec poslední časové (ne textové) možnosti
        // V případě, že neexistuje časová možnost, nastaví se na aktuální čas
        if($optionCount > 0){
            $start = isset($lastEnd) ? Carbon::parse($lastEnd)->format('H:i') : Carbon::now()->format('H:i');
        }

        // Nastavení konce hodinu po začátku
        $end = Carbon::parse($start)->addHour()->format('H:i');

        // přidání nové časové možnosti do pole
        $this->dates[$date]['options'][] = ['type' => 'time', 'start' => $start, 'end' => $end];

    }

    // Metoda pro odstranění časových možnosti
    public function removeDateOption($dateIndex, $optionIndex)
    {
        // Pokud možnost neexistuje, nelze ji odstranit
        if (!isset($this->dates[$dateIndex]['options'][$optionIndex])) return;

        // Pokud je pouze jedna možnost, nelze ji odstranit
        if (count($this->dates[$dateIndex]['options']) == 1) return;

        // Odstranění možnosti
        unset($this->dates[$dateIndex]['options'][$optionIndex]);

        // Přeindexování možností
        $this->dates[$dateIndex]['options'] = array_values($this->dates[$dateIndex]['options']);

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
    public function removeQuestion($index)
    {
        // Pokud otázka neexistuje, nelze ji odstranit
        if (!isset($this->questions[$index])) return;

        // Odstranění otázky
        unset($this->questions[$index]);
    }

    // Metoda pro přidání možnosti k otázce
    public function addQuestionOption($questionIndex)
    {
        // Přidání nové možnosti
        $this->questions[$questionIndex]['options'][] = ['text' => ''];
    }

    // Metoda pro odstranění možnosti k otázce
    public function removeQuestionOption($questionIndex, $optionIndex)
    {
        // Pokud je má otázka pouze dvě možnosti, nelze je samostatně odstranit
        if (count($this->questions[$questionIndex]['options']) <= 2) return;

        // Pokud možnost neexistuje, nelze ji odstranit
        if (!isset($this->questions[$questionIndex]['options'][$optionIndex])) return;

        unset($this->questions[$questionIndex]['options'][$optionIndex]);
    }



    // Metoda pro odeslání formuláře
    public function submit()
    {
        // Validace
        $validatedData = $this->validate();

        //dd($validatedData);

        dd($this->checkDuplicate($validatedData));

        // Kontrola duplicit
        if(!$this->checkDuplicate($validatedData)){
            
            return;
        }


        if ($this->save($validatedData)) {
            // Přesměrování
            return redirect()->route('polls.show', ['poll' => $this->poll]);
        }
    }


    // Metoda pro kontrolu duplicit jednotlivých možností
    private function checkDuplicate($validatedData) : bool
    {
        // kontrola duplicitních termínů
        foreach ($validatedData['dates'] as $date) {
            $optionContent = [];

            foreach($date['options'] as $option){
                if($option['type'] == 'time'){
                    $optionContent[] = strtolower($option['start'] . '-' . $option['end']);
                }
                else {
                    $optionContent[] = strtolower($option['text'] . '-text');
                }
            }

            // Porovnání všech termínů a unikátních termínů
            if (count($optionContent) !== count(array_unique($optionContent))) {
                return false;
            }
        }

        // Kontrola duplicitních otázek
        $questions = array_map('mb_strtolower', array_column($validatedData['questions'], 'text'));
    
        // Porovnání všech textů otázek a unikátních textů otázek
        if (count($questions) !== count(array_unique($questions))) {
            return false;
        }

        // Kontrola možností
        foreach ($validatedData['questions'] as $question) {
            $options = array_map('mb_strtolower', array_column($question['options'], 'text'));
            if (count($options) !== count(array_unique($options))) {
                return false;
            }
        }

        return true;
    }


    // Metoda pro uložení dat
    private function save($validatedData): bool
    {


        // Započetí transakce, pokud se něco nepovede, vrátí se zpět
        DB::beginTransaction();

        try {

            // Vytvoření nové ankety
            $poll = Poll::create([
                'title' => $validatedData['title'],
                'author_name' => $validatedData['userName'],
                'author_email' => $validatedData['userEmail'],
                'user_id' => Auth::id(),
                'deadline' => $validatedData['deadline'],
                'description' => $validatedData['description'],
                'comments' => $validatedData['settings']['comments'],
                'anonymous_votes' => $validatedData['settings']['anonymous'],
                'hide_results' => $validatedData['settings']['hide_results'],
                'invite_only' => $validatedData['settings']['invite_only'],
                //'password' => $validatedData['settings']['password'],
                'status' => 'active',
            ]);

            // Uložení časových možností a otázek
            $this->saveEachOption($poll, $validatedData);

            // Uložení dat
            DB::commit();

            $this->poll = $poll;
            return true;
        } catch (\Exception $e) {

            //dd($e);
            // Pokud se něco nepovede, vrátí se zpět
            DB::rollBack();
            return false;
        }
    }

    // Metoda pro uložení časových možností a možností otázek
    private function saveEachOption($poll, $validatedData)
    {
        $this->saveTimeOptions($poll, $validatedData['dates']);
        $this->saveQuestions($poll, $validatedData['questions']);
    }


    // Metoda pro uložení časových možností
    private function saveTimeOptions($poll, $dates)
    {
        $timeOptions = [];

        foreach ($dates as $date) {
            foreach ($date['options'] as $option) {
                if ($option['type'] == 'time') {
                    // Přidání časové možnosti
                    $timeOptions[] = [
                        'date' => $date['date'],
                        'start' => $option['start'],
                        'minutes' => (strtotime($option['end']) - strtotime($option['start'])) / 60,
                    ];
                } else {
                    // Přidání textové možnosti
                    $timeOptions[] = [
                        'date' => $date['date'],
                        'text' => $option['text'],
                    ];
                }
            }
        }

        return $poll->timeOptions()->createMany($timeOptions);
    }


    // Metoda pro uložení otázek
    private function saveQuestions($poll, $questions)
    {

        // Přidání otázek
        foreach ($questions as $question) {
            $newQuestion = $poll->questions()->create([
                'text' => $question['text'],
            ]);

            // Přidání možností k otázce
            foreach ($question['options'] as $option) {
                $newQuestion->options()->create([
                    'text' => $option['text'],
                ]);
            }
        }
    }

    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.form-create');
    }
}
