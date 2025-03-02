<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Models\Poll;

class FormCreate extends Component
{

    // Definice proměnných
    public $poll;
    public $user_name = "test";
    public $user_email = "kareltynek2000@gmail.com";
    public $title = "abc";
    public $description;
    public $dates = [];
    public $questions = [];


    public $settings = [
        'comments' => true,
        'anonymous' => false,
        'hide_results' => false,
    ];

    // Definice základních pravidel
    protected $rules = [
        'title' => 'required|string|min:3|max:255', // Název ankety
        'description' => 'nullable|max:1000', // Popis ankety
        'user_name' => 'required|string|min:3|max:255', // Jméno uživatele
        'user_email' => 'required|email', // Email uživatele
        'settings.comments' => 'boolean', // Komentáře
        'settings.anonymous' => 'boolean', // Anonymní hlasování
        'settings.hide_results' => 'boolean', // Skrytí výsledků
        'dates' => 'required|array|min:1', // Data
        'dates.*.date' => 'required|date', // Datum
        'dates.*.options' => 'required|array|min:1', // Možnosti data
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti
        'dates.*.options.*.start' => 'required_if:dates.*.options.*.type,time|date_format:H:i', // Začátek času
        'dates.*.options.*.end' => 'required_if:dates.*.options.*.type,time|date_format:H:i|after:dates.*.options.*.start', // Konec času, nefunguje jak má
        'dates.*.options.*.text' => 'required_if:dates.*.options.*.type,text', // Text možnosti
        'questions' => 'required|array', // Otázky
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
        if (!isset($date)) return;

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
        unset($this->questions[$index]);
    }

    // Metoda pro přidání možnosti k otázce
    public function addQuestionOption($questionIndex)
    {
        $this->questions[$questionIndex]['options'][] = ['text' => ''];
    }

    // Metoda pro odstranění možnosti k otázce
    public function removeQuestionOption($questionIndex, $optionIndex)
    {
        if(count($this->questions[$questionIndex]['options']) >= 2) return;
        unset($this->questions[$questionIndex]['options'][$optionIndex]);
    }



    // Metoda pro odeslání formuláře
    public function submit()
    {

        //dd($this->validate());


        // Validace
        $validatedData = $this->validate();


        //dd($validatedData);

        if($this->save($validatedData)){
            // Přesměrování
            return redirect()->route('polls.show', ['poll' => $this->poll]);
        }
    }







    // Metoda pro uložení dat
    private function save($validatedData): bool
    {

        // Vytvoření nové ankety
        $poll = Poll::create([
            'title' => $validatedData['title'],
            'author_name' => $validatedData['user_name'],
            'author_email' => $validatedData['user_email'],
            'description' => $validatedData['description'],
            'user_name' => $validatedData['user_name'],
            'user_email' => $validatedData['user_email'],
            'comments' => $validatedData['settings']['comments'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'status' => 'active',
        ]);

        // Přidání časových možností
        foreach ($validatedData['dates'] as $date) {
            foreach ($date['options'] as $option) {
                if ($option['type'] == 'time') {
                    // Přidání časové možnosti
                    $poll->timeOptions()->create([
                        'date' => $date['date'],
                        'start' => $option['start'],
                        'minutes' => (strtotime($option['end']) - strtotime($option['start'])) / 60,
                    ]);
                } else {
                    // Přidání textové možnosti
                    $poll->timeOptions()->create([
                        'date' => $date['date'],
                        'text' => $option['text'],
                    ]);
                }
            }
        }


        // Přidání otázek
        foreach ($validatedData['questions'] as $question) {
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

        $this->poll = $poll;
        return true;
    }

    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.form-create');
    }
}
