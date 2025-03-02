<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FormCreate extends Component
{

    // Definice proměnných
    public $poll;
    public $user_name;
    public $user_email;
    public $title;
    public $description;
    public $dates = [];


    public $settings = [
        'comments' => true,
        'anonymous' => false,
        'hide_results' => false,
    ];

    // Definice validací
    protected $rules = [
        'title' => 'required|string|min:3|max:255',
        'description' => 'nullable|max:1000',
        'user_name' => 'required|string|min:3|max:255',
        'user_email' => 'required|email',
        'settings.comments' => 'boolean',
        'settings.anonymous' => 'boolean',
        'settings.hide_results' => 'boolean',
    ];




    // Metoda mount
    function mount()
    {
        // Pokud je uživatel přihlášený, načtou se jeho údaje
        if (Auth::check()) {
            $this->user_name = Auth::user()->name;
            $this->user_email = Auth::user()->email;
        }
    }



    // Metoda pro přidání nového data
    public function addDate($date)
    {
        // Přidání nového data
        $this->dates[$date] = [
            'date' => '',
            'options' => [
                ['type' => 'time', 'start' => '11:00', 'end' => '12:00']
            ]
        ];
    }

    public function removeDate($date)
    {
        unset($this->dates[$date]);
    }

    // Metoda pro přidání nové časové možnosti
    public function addDateOption($dateIndex, $type)
    {
        dd($dateIndex);
        if($type == 'time')
            $this->dates[$date]['options'][] = ['type' => 'time', 'start' => '11:00', 'end' => '12:00'];
        else
            $this->dates[$date]['options'][] = ['type' => 'text', 'text' => ''];
    }





    // Metoda pro odeslání formuláře
    public function submit()
    {
        //dd("test");

        dd($this->validate());


        // Validace
        $validatedData = $this->validate();




        /*if($this->save($validatedData)){
            // Přesměrování
            return redirect()->route('polls.show', ['poll' => $this->poll]);
        }*/

    }







    // Metoda pro uložení dat
    private function save($validatedData) : bool
    {
        return true;
    }

    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.form-create');
    }
}
