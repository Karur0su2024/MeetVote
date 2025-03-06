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
use App\Traits\PollForm\Options;
use App\Traits\PollForm\PollData;

class FormCreate extends Component
{

    // Načtení dat ankety
    use PollData;

    // Načtení možností ankety
    use Options;

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
            $this->saveOptions($poll, $validatedData);

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



    // Metoda pro renderování komponenty
    public function render()
    {
        return view('livewire.poll.form-create');
    }
}
