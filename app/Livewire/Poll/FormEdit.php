<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\Poll;
use App\Models\TimeOption;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;


class FormEdit extends Component
{

    public $poll;

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
        'invite_only' => false,
        'password' => null,
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


    public $removedTimeOptions = [];
    public $removedQuestions = [];
    public $removedQuestionOptions = [];


    // Metoda mount
    public function mount($poll)
    {
        $this->poll = $poll;

        //dd($poll->comments);

        if($this->poll){
            $this->title = $poll->title;
            $this->description = $poll->description;
            $this->deadline = $poll->deadline;
            $this->settings['anonymous'] = $poll->anonymous_votes == 1 ? true : false;
            $this->settings['comments'] = $poll->comments == 1 ? true : false;
            $this->settings['hide_results'] = $poll->hide_results == 1 ? true : false;
            $this->settings['invite_only'] = $poll->invite_only == 1 ? true : false;
            $this->settings['password'] = $poll->password;
        }

        //dd($this->settings);

        $this->loadTimeOptions();
        $this->loadQuestions();
    }

    public function loadTimeOptions(){
        $dates = $this->poll->timeOptions->groupBy('date')->toArray();

        foreach($dates as $dateIndex => $options){
            $timeOptions = [];
            foreach($options as $option){
                if($option['start'] != null){
                    $timeOptions[] = [
                        'id' => $option['id'],
                        'type' => 'time',
                        'start' => Carbon::parse($option['start'])->format('H:i'),
                        'end' => Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i'),
                    ];
                }
                else {
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


    public function loadQuestions(){
        $questions = $this->poll->questions;

        foreach($questions as $question){
            //dd($question);
            $questionOptions = [];
            foreach($question->options as $option){
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


        //Odstanění všech možností

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

    // Metoda pro přidání nové časové možnosti
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


    
        // Pokud je možnost s ID, uloží se do pole pro odstranění
        if(isset($this->dates[$dateIndex]['options'][$optionIndex]['id'])){

            $this->removedTimeOptions[] = $this->dates[$dateIndex]['options'][$optionIndex]['id'];
        }

        // Odstranění možnosti z pole
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

        if(isset($this->questions[$index]['id'])){
            $this->removedQuestions[] = $this->questions[$index]['id'];
        }

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

        if(isset($this->questions[$questionIndex]['options'][$optionIndex]['id'])){
            $this->removedQuestionOptions[] = $this->questions[$questionIndex]['options'][$optionIndex]['id'];
        }

        unset($this->questions[$questionIndex]['options'][$optionIndex]);
    }


    public function submit(){
        //dd($this->removedTimeOptions, $this->removedQuestions, $this->removedQuestionOptions);


        $validatedData = $this->validate();
        //dd($validatedData);

        $this->poll->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            'anonymous_votes' => $validatedData['settings']['anonymous'],
            'comments' => $validatedData['settings']['comments'],
            'hide_results' => $validatedData['settings']['hide_results'],
            'invite_only' => $validatedData['settings']['invite_only'],
            'password' => $validatedData['settings']['password'],
        ]);

        
        foreach($this->removedTimeOptions as $optionIndex){
            $option = TimeOption::find($optionIndex);
            $option->delete();
        }

        foreach($this->removedQuestionOptions as $optionIndex){
            $option = QuestionOption::find($optionIndex);
            $option->delete();
        }

        foreach($this->removedQuestions as $questionIndex){
            $question = PollQuestion::find($questionIndex);
            $question->delete();
        }
        

        // Přidat uložení časových možností

        // Přidat uložení otázek


        return redirect()->route('polls.show', $this->poll);

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




    public function render()
    {
        return view('livewire.poll.form-edit');
    }
}
