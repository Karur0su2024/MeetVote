<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use App\Models\TimeOption;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;
use App\Models\PollQuestion;
use App\Models\QuestionOption;
use App\Traits\HasPollFormOptions;


class FormEdit extends Component
{

    use HasPollFormOptions;

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
    



    public function submit(){
        //dd($this->removedTimeOptions, $this->removedQuestions, $this->removedQuestionOptions);


        $validatedData = $this->validate();

        //dd($validatedData);

        // Kontrola duplicit
        if(!$this->checkDuplicate($validatedData)){
            
            return;
        }




        //dd($validatedData);

        // Uložení změn ankety
        if(!$this->save($validatedData)){
            return;
        }
        



        return redirect()->route('polls.show', $this->poll);

    }


    private function save($validatedData) : bool {
        // Vytvoření nové ankety


        DB::beginTransaction();

        try {
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
    
            //dd($this->removedTimeOptions, $this->removedQuestions, $this->removedQuestionOptions);

            //dd($this->removedTimeOptions);
            
            foreach($this->removedTimeOptions as $optionIndex){
                $option = TimeOption::find($optionIndex);
                //dd($option);
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

            $this->saveTimeOptions($this->poll, $validatedData['dates']);
            $this->saveQuestions($this->poll, $validatedData['questions']);

            DB::commit();

            return true;
        }
        catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return false;


        }




    }

    // Metoda pro uložení časových možností
    private function saveTimeOptions($poll, $dates)
    {
        foreach ($dates as $date) {
            foreach ($date['options'] as $option) {
                if ($option['type'] == 'time') {
                    $minutes = Carbon::parse($option['end'])->diffInMinutes($option['start']);
                    //dd($option);

                    if(isset($option['id'])){
                        // Aktualizace časové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        $newOption->update([
                            'start' => $date['date'] . ' ' . $option['start'],
                            'minutes' => $minutes
                        ]);
                    }
                    else {
                        //dd($option);
                        // Přidání nové časové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'start' => $date['date'] . ' ' . $option['start'],
                            'minutes' => $minutes
                        ]);
                    }
                } else {

                    if(isset($option['id'])){
                        // Aktualizace textové možnosti, která již existuje
                        $newOption = TimeOption::find($option['id']);
                        $newOption->update([
                            'text' => $option['text'],
                        ]);
                    }
                    else {
                        // Přidání textové možnosti do databáze
                        $poll->timeOptions()->create([
                            'date' => $date['date'],
                            'text' => $option['text'],
                        ]);
                    }
                }
            }
        }


    }


    // Metoda pro uložení otázek
    private function saveQuestions($poll, $questions)
    {
        // Přidání otázek
        foreach ($questions as $question) {
            if(!isset($question['id'])){
                $newQuestion = $poll->questions()->create([
                    'text' => $question['text'],
                ]);
            }
            else {
                $newQuestion = PollQuestion::find($question['id']);
                $newQuestion->update([
                    'text' => $question['text'],
                ]);
            }
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
