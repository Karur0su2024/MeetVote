<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\HasPollFormOptions;

class FormCreate extends Component
{

    use HasPollFormOptions;

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
        'dates.*.options.*.type' => 'required|in:time,text', // Typ možnosti (text nebo čas)
        'dates.*.options.*.start' => 'required_if:options.*.type,time|date_format:H:i', // Začátek časové možnosti
        'dates.*.options.*.end' => 'required_if:options.*.type,time|date_format:H:i|after:options.*.start', // Konec časové možnosti
        'dates.*.options.*.text' => 'required_if:options.*.type,text|string', // Textová možnost
    ])]
    public $dates = [];




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

    // Metoda pro odeslání formuláře
    public function submit()
    {
        // Validace
        $validatedData = $this->validate();


        // Kontrola duplicit
        if(!$this->checkDuplicate($validatedData)){
            
            return;
        }

        $poll = $this->save($validatedData);

        if ($poll) {
            // Uložení klíče správce ankety do session
            session()->put('poll_' . $poll->public_id . '_adminKey', $poll->admin_key);
            //dd(session()->get('poll_' . $poll->public_id . '_adminKey'));
            // Přesměrování
            return redirect()->route('polls.show', $poll);
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
    private function save($validatedData): ?Poll
    {

        // Započetí transakce, pokud se něco nepovede, vrátí se zpět
        DB::beginTransaction();

        try {

            // Vytvoření nové ankety
            $poll = Poll::create([
                'title' => $validatedData['title'],
                'public_id' => Str::random(40),
                'admin_key' => Str::random(40),
                'author_name' => $validatedData['userName'],
                'author_email' => $validatedData['userEmail'],
                'user_id' => Auth::id(),
                'deadline' => $validatedData['deadline'],
                'description' => $validatedData['description'],
                'comments' => $validatedData['settings']['comments'],
                'anonymous_votes' => $validatedData['settings']['anonymous'],
                'hide_results' => $validatedData['settings']['hide_results'],
                'invite_only' => $validatedData['settings']['invite_only'],
                'password' => $validatedData['settings']['password'],
                'status' => 'active',
            ]);

            // Uložení časových možností a otázek
            $this->saveEachOption($poll, $validatedData);

            // Uložení dat
            DB::commit();

            return $poll;
        } catch (\Exception $e) {

            //dd($e);
            // Pokud se něco nepovede, vrátí se zpět
            DB::rollBack();
            return null;
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
