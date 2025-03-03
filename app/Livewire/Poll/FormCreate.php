<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;

class FormCreate extends Component
{

    // Definice proměnných
    public $poll;
    public $user_name;
    public $user_email;
    public $title = "abc";
    public $description;
    public $deadline;
    public $dates = [];
    public $questions = [];
    public $postAsGuest = false;


    public $settings = [
        'comments' => true,
        'anonymous' => false,
        'hide_results' => false,
        'password' => null,
        'invite_only' => false,
    ];

    // Definice základních pravidel
    protected $rules = [
        'title' => 'required|string|min:3|max:255', // Název ankety
        'description' => 'nullable|max:1000', // Popis ankety
        'user_name' => 'required|string|min:3|max:255', // Jméno uživatele
        'user_email' => 'required|email', // Email uživatele
        'deadline' => 'nullable|date', // Deadline
        'settings.invite_only' => 'boolean', // Pouze na pozvánku
        'settings.comments' => 'boolean', // Komentáře
        'settings.anonymous' => 'boolean', // Anonymní hlasování
        'settings.hide_results' => 'boolean', // Skrytí výsledků
        'settings.password' => 'nullable|string|min:3', // Heslo
        'dates' => 'required|array|min:1', // Data
        'dates.*.date' => 'required|date', // Datum
        'dates.*.options' => 'required|array|min:1', // Možnosti data
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti
        'dates.*.options.*.start' => 'required_if:dates.*.options.*.type,time|date_format:H:i', // Začátek času
        'dates.*.options.*.end' => 'required_if:dates.*.options.*.type,time|date_format:H:i|after:dates.*.options.*.start', // Konec času, nefunguje jak má
        'dates.*.options.*.text' => 'required_if:dates.*.options.*.type,text', // Text možnosti
        'questions' => 'nullable|array', // Otázky
        'questions.*.text' => 'required|string|min:3|max:255', // Text otázky
        'questions.*.options' => 'required|array|min:2', // Možnosti otázky
        'questions.*.options.*.text' => 'required|string|min:3|max:255', // Text možnosti
    ];



    // Metoda mount
    function mount()
    {
        // Pokud je uživatel přihlášený, načtou se jeho údaje
        if (Auth::check()) {
            $this->user_name = Auth::user()->name;
            $this->user_email = Auth::user()->email;
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
            'options' => [
                ['type' => 'time', 'start' => '11:00', 'end' => '12:00']
            ]
        ];

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
        //dd($dateIndex);
        if ($type == 'time')
            // Přidání nové časové možnosti
            $this->dates[$date]['options'][] = ['type' => 'time', 'start' => '11:00', 'end' => '12:00'];
        else
            // Přidání nové textové možnosti
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
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

        // Seřazení možností podle klíče
        ksort($this->dates[$dateIndex]['options']);
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
        //dd($this->validate());

        // Validace
        $validatedData = $this->validate();


        if ($this->save($validatedData)) {
            // Přesměrování
            return redirect()->route('polls.show', ['poll' => $this->poll]);
        }
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
                'author_name' => $validatedData['user_name'],
                'author_email' => $validatedData['user_email'],
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

            dd($e);
            // Pokud se něco nepovede, vrátí se zpět
            DB::rollBack();
            return false;
        }
    }


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
